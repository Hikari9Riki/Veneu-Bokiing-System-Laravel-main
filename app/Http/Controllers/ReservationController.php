<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // List View (My Reservations)
    public function index()
    {
        $reservations = Reservation::where('userId', Auth::id())
                                   ->with('venue')
                                   ->latest()
                                   ->get();
        return view('reservations.index', compact('reservations'));
    }

    // Create Form
    public function create()
    {
        $venues = Venue::all(); 
        return view('reservations.create', compact('venues'));
    }

    // Store Reservation
    public function store(Request $request)
    {
        $request->validate([
            'venueID' => 'required',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'reason' => 'required|string',
        ]);

        // Basic conflict check
        $start = date('Y-m-d H:i:s', strtotime($request->start_datetime));
        $end = date('Y-m-d H:i:s', strtotime($request->end_datetime));
        $date = date('Y-m-d', strtotime($request->start_datetime));

        $conflict = Reservation::where('venueID', $request->venueID)
            ->where('date', $date)
            ->where('status', '!=', 'Rejected')
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('startTime', [date('H:i:s', strtotime($start)), date('H:i:s', strtotime($end))])
                      ->orWhereBetween('endTime', [date('H:i:s', strtotime($start)), date('H:i:s', strtotime($end))]);
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Venue is occupied at this time.');
        }

        Reservation::create([
            'userId' => Auth::id(),
            'venueID' => $request->venueID,
            'date' => $date,
            'startTime' => date('H:i:s', strtotime($start)),
            'endTime' => date('H:i:s', strtotime($end)),
            'reason' => $request->reason,
            'status' => 'Pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking Submitted!');
    }

    // JSON Data for Calendar
    public function getReservations(Request $request)
    {
        $query = Reservation::with('venue')->where('status', '!=', 'Rejected');

        if ($request->has('venue_id') && $request->venue_id != '') {
            $query->where('venueID', $request->venue_id);
        }

        $events = $query->get()->map(function ($reservation) {
            return [
                'title' => $reservation->venue->name,
                'start' => $reservation->date . 'T' . $reservation->startTime,
                'end' => $reservation->date . 'T' . $reservation->endTime,
                'color' => $reservation->userId == Auth::id() ? '#007A5E' : '#C5A059',
            ];
        });

        return response()->json($events);
    }
}