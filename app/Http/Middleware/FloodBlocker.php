<?php

namespace App\Http\Middleware;

use Closure;

class FloodBlocker
{
    public function handle($request, Closure $next)
    {
//        $userAgent = $request->header('User-Agent');
//
//        if (strpos($userAgent, '51.0.2704.103') !== false) {
//            abort(400);
//        }

        return $next($request);
    }
}
