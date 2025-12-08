<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BuyerOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        // Buyers are stored with role 'client' in the users table
        if (Auth::check() && Auth::user()->role === 'client') {
            return $next($request);
        }

        abort(403);
    }
}
