<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class UserController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Validate request
        $request->validate([
            'status' => 'required|in:Cancelled',
        ]);

        $reservation->update([
            'status' => $request->status,
            // 'admin_remark' => $request->admin_remark // Optional: if you have this column
        ]);

        return redirect()->back()->with('success', "Reservation has been {$request->status}");
    }
}
