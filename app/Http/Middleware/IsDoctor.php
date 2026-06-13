<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsDoctor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || auth()->user()->role !== 'doctor') {
            abort(403, 'Unauthorized. Doctor access required.');
        }

        return $next($request);
    }
}
