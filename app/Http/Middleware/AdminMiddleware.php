<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Check if user is logged in
        // 2. Normalize the role string to avoid case/space errors
        if (Auth::check() && strtolower(trim(Auth::user()->role)) === 'admin') {
            return $next($request);
        }

        // If not admin, block access
        abort(403, 'Unauthorized - Admin access only.');
    }
}