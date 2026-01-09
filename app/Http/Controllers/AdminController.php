<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Fetch only Pending reservations
        // 2. Eager load 'user' (to see who booked) and 'venue'
        // 3. Order by the Event Date (Urgency) or Created Date (First Come First Serve)
        $pendingReservations = Reservation::where('status', 'Pending')
            ->with(['user', 'venue']) 
            ->orderBy('date', 'asc') // Shows upcoming events first
            ->get();

        return view('admin.dashboard', compact('pendingReservations'));
    }

    // Logic to update status (Approve/Reject)
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Validate request
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'admin_remark' => 'nullable|string'
        ]);

        $reservation->update([
            'status' => $request->status,
            // 'admin_remark' => $request->admin_remark // Optional: if you have this column
        ]);

        return redirect()->back()->with('success', "Reservation has been {$request->status}");
    }
}