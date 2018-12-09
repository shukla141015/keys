<?php

namespace App\Http\Middleware;

use App\Support\Facades\Human;
use Closure;

class KeyPageHumanVerification
{
    public function handle($request, Closure $next, $coinType)
    {
        $pageNumber = $request->segment('2');

        if (Human::isReal() || app()->runningUnitTests() || allow_robots($coinType, $pageNumber)) {
            return $next($request);
        }

        Human::putRedirectUrl($request->url());

        return redirect()->route('humanVerification');
    }
}
