<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  The role required to access the route
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // Check if user has the required role
        if (!$request->user()->hasRole($role)) {
            // Redirect to patients index with error message
            return redirect()->route('patients.index')->with('error', 'Unauthorized action. You do not have the required permissions.');
        }

        return $next($request);
    }
}
