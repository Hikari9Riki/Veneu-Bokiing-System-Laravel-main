<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Fetch only Pending reservations
        // 2. Eager load 'user' and 'venue'
        // 3. Order by 'startDate' (Urgency) instead of the old 'date' column
        $pendingReservations = Reservation::where('status', 'Pending')
            ->with(['user', 'venue']) 
            ->orderBy('startDate', 'asc') // UPDATED: Use 'startDate'
            ->get();

        return view('admin.dashboard', compact('pendingReservations'));
    }

    // You likely also have an updateStatus method here
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Validate input (Approved or Rejected)
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $reservation->status = $request->status;
        $reservation->save();

        return redirect()->route('admin.dashboard')->with('success', "Reservation has been {$request->status}.");
    }
}