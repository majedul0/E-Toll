<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOfficial
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()
                ->route('official.login')
                ->withErrors(['identifier' => 'Please login with an official account to continue.']);
        }

        if (Auth::user()->role !== 'official') {
            return redirect()
                ->route('dashboard')
                ->withErrors(['identifier' => 'This area is restricted to authorized officials.']);
        }

        return $next($request);
    }
}

