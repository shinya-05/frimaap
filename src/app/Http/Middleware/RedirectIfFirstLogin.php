<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfFirstLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->profile_completed) {
            return redirect()->route('profile.setup');
        }

        return $next($request);
    }
}
