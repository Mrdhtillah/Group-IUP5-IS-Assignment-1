<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 


class CheckUserCredentials
{
    public function handle($request, Closure $next)
    {
        // Check if the user is logged in
        if (Auth::check()) {
            // User is authenticated, proceed to the next middleware or route
            return $next($request);
        }

        // If not authenticated, you can perform custom authentication checks
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // User is authenticated, proceed
            return $next($request);
        }

        // Authentication failed, redirect or return an error response
        return redirect()->route('login')->with('error', 'Authentication failed.');

        // Alternatively, return a JSON response for API endpoints:
        // return response()->json(['error' => 'Authentication failed.'], 401);
    }
}