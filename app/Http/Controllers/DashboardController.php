<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Venue;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        
        // Get unique Kulliyyah names from the 'kuliyyah' column
        // This returns a simple array: ['ICT', 'ENGIN', 'AIKOL']
        $kulliyyahs = Venue::select('kuliyyah')->distinct()->pluck('kuliyyah');

        return view('user.dashboard', compact('kulliyyahs'));
    }

    public function reservation()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        $reservations = Reservation::where('user_id', $user->id) // Assuming 'id' is the foreign key for users
        // CHANGE THIS LINE: use 'startDate' instead of 'date'
        ->whereDate('startDate', '>=', \Carbon\Carbon::today()) 
        ->with('venue') 
        ->orderBy('updated_at', 'desc') 
        ->get();

        return view('user.reservation', compact('user', 'reservations'));
    }

        public function homepage()
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


}