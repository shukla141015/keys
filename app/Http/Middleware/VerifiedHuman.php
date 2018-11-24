<?php

namespace App\Http\Middleware;

use App\Support\Facades\Human;
use Closure;

class VerifiedHuman
{
    public function handle($request, Closure $next)
    {
        if (app()->runningUnitTests() || Human::isReal()) {
            return $next($request);
        }

        Human::putRedirectUrl($request->url());

        return redirect()->route('humanVerification');
    }
}
