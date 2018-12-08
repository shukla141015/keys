<?php

namespace App\Http\Middleware;

use App\Keys\PageNumbers\BitcoinPageNumber;
use App\Keys\PageNumbers\EthereumPageNumber;
use App\Support\Enums\CoinType;
use App\Support\Facades\Human;
use Closure;
use RuntimeException;

class KeyPageHumanVerification
{
    public function handle($request, Closure $next, $coinType)
    {
        $page = $request->segment('2');

        if (Human::isReal() || $this->robotsAllowed($coinType, $page)) {
            return $next($request);
        }

        Human::putRedirectUrl($request->url());

        return redirect()->route('humanVerification');
    }

    private function robotsAllowed(string $coinType, string $page)
    {
        if (app()->runningUnitTests()) {
            return true;
        }

        switch ($coinType) {
            case CoinType::BITCOIN:
                return BitcoinPageNumber::allowRobots($page);
            case CoinType::ETHEREUM:
                return EthereumPageNumber::allowRobots($page);
        }

        throw new RuntimeException('Invalid CoinType specified in middleware');
    }
}
