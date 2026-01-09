<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function getVenues(Request $request)
{
    // Debug: If you visit /api/venues?kuliyyah=KICT in your browser, 
    // you should see the JSON data.
    
    $query = \App\Models\Venue::query();

    if ($request->has('kuliyyah')) {
        $query->where('kuliyyah', $request->kuliyyah);
    }

    return response()->json($query->get());
}
}
