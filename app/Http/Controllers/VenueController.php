<?php

namespace App\Http\Controllers;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        // Fetch all venues, ordered by Kuliyyah then Name
        $venues = Venue::orderBy('kuliyyah', 'asc')
                       ->orderBy('name', 'asc')
                       ->get();

        return view('admin.venues', compact('venues'));
    }

    public function create()
    {
        return view('venues.create');
    }

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

    public function store(Request $request)
    {
        $request->validate([
            'venueID' => 'required|string|unique:venues,venueID|max:20', // Unique ID check
            'name' => 'required|string|max:255',
            'kuliyyah' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'available' => 'required|boolean',
        ]);

        Venue::create([
            'venueID' => $request->venueID, // Manually entered ID
            'name' => $request->name,
            'kuliyyah' => $request->kuliyyah,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'available' => $request->available,
        ]);

        return redirect()->route('venues.index')->with('success', 'Venue created successfully!');
    }

    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'kuliyyah' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'available' => 'required|boolean',
        ]);

        $venue->update([
            'name' => $request->name,
            'kuliyyah' => $request->kuliyyah,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'available' => $request->available,
        ]);

        return redirect()->route('venues.index')->with('success', 'Venue updated successfully!');
    }
}
