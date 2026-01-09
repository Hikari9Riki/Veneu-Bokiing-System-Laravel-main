<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // 1. Get reservations for the current user
        // 2. Filter: Date must be Today or Future (>= today)
        // 3. Sort: Latest updates first
        $reservations = Reservation::where('user_id', $user->id)
            ->whereDate('date', '>=', Carbon::today()) // Hide past history
            ->with('venue') // Eager load venue to prevent lag
            ->orderBy('updated_at', 'desc') // Latest changes on top
            ->get();

        return view('user.dashboard', compact('user', 'reservations'));
    }
}