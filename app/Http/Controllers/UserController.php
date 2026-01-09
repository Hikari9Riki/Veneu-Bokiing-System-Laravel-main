<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;

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

    public function showProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

// ==========================================
    //  PART 1: PROFILE MANAGEMENT (For Self)
    // ==========================================

    // Show the "User Detail" page
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user')); // We created this view earlier
    }

    // Update own profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // Ensure email is unique but ignore the current user's ID
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed', // 'confirmed' looks for password_confirmation field
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Only update password if one was typed in
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    // ==========================================
    //  PART 2: ADMIN MANAGEMENT (For Managing Others)
    // ==========================================

    // List all users (Admin Dashboard -> Manage Users)
    public function index()
    {
        // Check if admin (Double protection alongside middleware)
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    // Delete a user (Admin only)
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User removed successfully.');
    }
}