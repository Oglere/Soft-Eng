<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAuthenticated
{
    public function handle(Request $request, Closure $next, $role, $is_deleted = null)
    {
        if (!Auth::check()) {
            return redirect('/auth/login')->with('error', 'Please log in first.');
        }

        // Optional: restrict by role (if your users table has a `role` column)
        if ($role && Auth::user()->role !== $role) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        if ($is_deleted && Auth::user()->is_deleted !== 0) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
