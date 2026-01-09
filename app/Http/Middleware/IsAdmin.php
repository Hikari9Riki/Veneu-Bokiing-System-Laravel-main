<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in AND is an admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // If not admin, send them back to normal dashboard with error
        return redirect('/dashboard')->with('error', 'You do not have admin access.');
    }
}