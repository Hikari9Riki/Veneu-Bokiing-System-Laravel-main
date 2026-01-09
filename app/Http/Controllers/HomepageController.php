<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Reservation;

class HomepageController extends Controller
{
    public function index()
    {
        // Get unique Kulliyyah names from the 'kuliyyah' column
        // This returns a simple array: ['ICT', 'ENGIN', 'AIKOL']
        $kulliyyahs = Venue::select('kuliyyah')->distinct()->pluck('kuliyyah');

        return view('homepage', compact('kulliyyahs'));
    }

    public function getVenues(Request $request)
    {
        $query = Venue::query();

        // Filter by the string column 'kuliyyah'
        if ($request->has('kuliyyah')) {
            $query->where('kuliyyah', $request->kuliyyah);
        }

        return response()->json($query->get());
    }

    public function calendar(Request $request)
    {
        $query = Reservation::where('status', 'approved');

        if ($request->filled('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }

        $reservations = $query->get();

        return response()->json(
            $reservations->map(function ($r) {
                return [
                    'title' => 'Booked',
                    'start' => $r->booking_date . 'T' . $r->start_time,
                    'end'   => $r->booking_date . 'T' . $r->end_time,
                    'color' => '#dc3545'
                ];
            })
        );
    }

}
