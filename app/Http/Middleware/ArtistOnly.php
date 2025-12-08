<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ArtistOnly
{


    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'artist') {
            return $next($request);
        }
        abort(403);
    }
}
