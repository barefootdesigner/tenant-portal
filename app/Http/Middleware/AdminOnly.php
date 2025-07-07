<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
{
    if (!auth()->user()?->hasRole('Admin')) {
        auth()->logout(); // Log the user out
        // Optionally, redirect back to login with a message
        return redirect()->route('filament.admin.auth.login')->withErrors([
            'email' => 'You are not an admin.',
        ]);
    }
    return $next($request);
}

}
