<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        // Changed 'userId' to 'user_id'
        $reservations = Reservation::where('user_id', Auth::id())
                                   ->with('venue')
                                   ->latest()
                                   ->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $venues = Venue::all(); 
        return view('reservations.create', compact('venues'));
    }

    public function store(Request $request)
    {
        // 1. Validate inputs (names must match the View form)
        $request->validate([
            'venueID'   => 'required',
            'startDate' => 'required|date',
            'endDate'   => 'required|date|after_or_equal:startDate',
            'startTime' => 'required',
            'endTime'   => 'required',
            'reason'    => 'required|string',
        ]);

        // 2. Prepare Data for Conflict Check
        // We combine date and time to make comparison easier
        $startFull = Carbon::parse($request->startDate . ' ' . $request->startTime);
        $endFull   = Carbon::parse($request->endDate . ' ' . $request->endTime);

        // Check if End time is after Start time
        if ($endFull->lessThanOrEqualTo($startFull)) {
            return back()->with('error', 'End time must be after start time.');
        }

        // 3. Check for Conflicts
        // We check if any existing reservation overlaps with the requested time range
        $conflict = Reservation::where('venueID', $request->venueID)
            ->where('status', '!=', 'Rejected') // Ignore rejected bookings
            ->where(function ($query) use ($request) {
                // Overlap Logic: (StartA <= EndB) and (EndA >= StartB)
                $query->where('startDate', '<=', $request->endDate)
                      ->where('endDate', '>=', $request->startDate)
                      ->where('startTime', '<', $request->endTime)
                      ->where('endTime', '>', $request->startTime);
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Venue is already booked for this time slot.');
        }

        // 4. Generate Unique ID
        // Format: RES-TIMESTAMP-RANDOM (e.g., RES-173645-A1B2)
        $resID = 'RES-' . time() . '-' . strtoupper(substr(uniqid(), -4));

        // 5. Create Reservation
        Reservation::create([
            'reservationID' => $resID,        // Must generate this manually!
            'user_id'       => Auth::id(),    // Matches DB column
            'venueID'       => $request->venueID,
            'startDate'     => $request->startDate,
            'endDate'       => $request->endDate,
            'startTime'     => $request->startTime,
            'endTime'       => $request->endTime,
            'reason'        => $request->reason,
            'status'        => 'Pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking Submitted Successfully!');
    }


    // JSON Data for Calendar
    public function getReservations(Request $request)
    {
        // CHANGE: Only load reservations where status is strictly 'Approved'
        $query = Reservation::with('venue')->where('status', 'Approved');

        if ($request->has('venue_id') && $request->venue_id != '') {
            $query->where('venueID', $request->venue_id);
        }

        $events = $query->get()->map(function ($reservation) {
            
            // Safety check for null venues
            $venueName = $reservation->venue ? $reservation->venue->name : 'Unknown Venue';
            $venueLoc  = $reservation->venue ? $reservation->venue->location : 'Unknown Location';
            $venueKul  = $reservation->venue ? $reservation->venue->kuliyyah : 'Unknown Kuliyyah';

            return [
                'title' => $venueName,
                'start' => $reservation->startDate . 'T' . $reservation->startTime,
                'end'   => $reservation->endDate . 'T' . $reservation->endTime,
                'color' => $reservation->user_id == Auth::id() ? '#007A5E' : '#C5A059',
                'extendedProps' => [
                    'location' => $venueLoc,
                    'kuliyyah' => $venueKul,
                ],
            ];
        });

        return response()->json($events);
    }
}