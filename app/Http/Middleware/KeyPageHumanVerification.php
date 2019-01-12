<?php

namespace App\Http\Middleware;

use App\Support\Facades\Human;
use Closure;

class KeyPageHumanVerification
{
    public function handle($request, Closure $next, $coinType)
    {
        if (! config('keys.recaptcha_secret_key') || ! config('keys.recaptcha_site_key')) {
            return $next($request);
        }

        $pageNumber = $request->segment('2');

        if (Human::isReal() || app()->runningUnitTests() || allow_robots($coinType, $pageNumber)) {
            return $next($request);
        }

        Human::putRedirectUrl($request->url());

        return redirect()->route('humanVerification');
    }
}
