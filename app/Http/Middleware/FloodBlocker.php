<?php

namespace App\Http\Middleware;

use Closure;

class FloodBlocker
{
    public function handle($request, Closure $next)
    {
//        $userAgent = $request->header('User-Agent');
//
//        if (strpos($userAgent, '68.0.3440.106') !== false) {
//            abort(400);
//        }

        return $next($request);
    }
}
