<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    // Show the booking form
    public function create()
    {
        $venues = Venue::where('available', true)->get();
        return view('reservations.create', compact('venues'));
    }

    // Store the booking in the database
    public function store(Request $request)
    {
        $request->validate([
            'venueID'   => 'required',
            'date'      => 'required|date',
            'reason'    => 'nullable|string|max:255',
            'startTime' => 'required',
            'endTime'   => 'required|after:startTime', // Ensure End is after Start
        ]);

        // 1. CHECK FOR CONFLICTS
        // We look for any APPROVED reservation at the same venue and date
        // that overlaps with the requested time.
        $conflicting = Reservation::where('venueID', $request->venueID)
            ->where('date', $request->date)
            ->where('status', 'Approved') // Only block if it is already Approved
            ->where(function ($query) use ($request) {
                $query->where('startTime', '<', $request->endTime)
                    ->where('endTime', '>', $request->startTime);
            })
            ->exists(); // Returns true if a conflict is found

        // 2. IF CONFLICT EXISTS, STOP AND RETURN ERROR
        if ($conflicting) {
            return back()->with('error', 'This venue is already booked for the selected time. Please choose another slot.')
                        ->withInput(); // Keep the user's input
        }

        // 3. NO CONFLICT? PROCEED TO SAVE
        $reservation = new Reservation();
        $reservation->reservationID = 'RES-' . strtoupper(uniqid());
        $reservation->date = $request->date;
        $reservation->startTime = $request->startTime;
        $reservation->endTime = $request->endTime;
        $reservation->reason = $request->reason;
        $reservation->status = 'Pending';
        $reservation->venueID = $request->venueID;
        $reservation->user_id = Auth::user()->id;
        $reservation->save();

        return redirect('/dashboard')->with('success', 'Reservation submitted!');
    }

    // Add this at the top with other imports


    // Add this new method inside your class ReservationController
    public function getReservations(Request $request): JsonResponse
    {
        $query = Reservation::query();
        $venues = Venue::all();

        // 1. Filter by Venue if selected
        if ($request->has('venue_id') && $request->venue_id != '') {
            $query->where('venueID', $request->venue_id);
        }

        // 2. Get reservations (only approved ones? Optional)
        // $query->where('status', 'Approved');
        $query->where('status', 'Approved'); 
        $events = $query->get();

        // 3. Format for FullCalendar
        $formattedEvents = $events->map(function ($reservation) use ($venues) {
            return [
                'id'    => $reservation->reservationID,
                'title' => $venues->where('venueID', $reservation->venueID)->first()->name ?? 'Unknown Venue', // Or show User Name if admin
                // Combine Date + Time for FullCalendar (ISO 8601)
                'start' => $reservation->date . 'T' . $reservation->startTime,
                'end'   => $reservation->date . 'T' . $reservation->endTime,
                'color' => '#dc3545', // Red color for booked slots
                'extendedProps' => [
                    'location' => $venues->where('venueID', $reservation->venueID)->first()->location ?? 'Unknown Location',
                    'kuliyyah' => $venues->where('venueID', $reservation->venueID)->first()->kuliyyah ?? 'Unknown Kuliyyah',
                ],
            ];
        });

        return response()->json($formattedEvents);
    }
}