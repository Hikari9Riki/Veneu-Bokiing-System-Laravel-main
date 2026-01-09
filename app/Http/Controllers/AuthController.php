<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Needed for password hashing

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }

    // Submit register form
    public function register(Request $request) {
        // 1. Validate Input
        $credentials = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' looks for password_confirmation field
            'phone'    => 'nullable|string',
            'role'     => 'required|in:admin,student,staff', // Ensure role is valid
        ]);

        // 2. Create the user
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => $request->role, // Save the role
        ]);

        // 3. Redirect back to User Management Dashboard
        // Do NOT use Auth::login($user) here, or you will be logged out as Admin!
        return redirect()->route('admin.users.index')->with('success', 'New user registered successfully!');
    }

    // Show Login Form
    public function showLogin() {
        return view('auth.login');
    }

    // Handle Login Logic
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 2. Check their role
            if ($user->role === 'admin') {
                // Send Admin to the Admin Dashboard
                // Make sure your route in web.php is named 'admin.dashboard'
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}