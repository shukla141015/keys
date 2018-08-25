<?php

namespace App\Http\Controllers;

use App\Events\RandomPageGenerated;
use App\Keys\BitcoinPageKeys;
use App\Keys\PageNumbers\BitcoinPageNumber;
use App\Models\CoinStats;
use App\Support\Enums\CoinType;

class BitcoinPagesController extends Controller
{
    public function index($pageNumber = null)
    {
        $btcPageNumber = new BitcoinPageNumber($pageNumber);

        if ($btcPageNumber->shouldRedirect()) {
            return $btcPageNumber->redirect();
        }

        $keys = BitcoinPageKeys::generate($pageNumber);

        CoinStats::coinPageViewed(CoinType::BITCOIN, count($keys));

        return view('bitcoin-page', [
            'pageNumber'          => $pageNumber,
            'nextPage'            => increment_string($pageNumber),
            'previousPage'        => decrement_string($pageNumber),
            'lastPage'            => BitcoinPageNumber::lastPageNumber(),
            'isOnFirstPage'       => $pageNumber === '1',
            'isOnLastPage'        => $pageNumber === BitcoinPageNumber::lastPageNumber(),
            'isShortNumberString' => $btcPageNumber->isShortNumberString(),
            'isSmallNumber'       => $btcPageNumber->isSmallNumber(),
            'keys'                => $keys,
        ]);
    }

    public function randomPage()
    {
        $randomPage = BitcoinPageNumber::random();

        RandomPageGenerated::dispatch($randomPage);

        CoinStats::randomPageGenerated(CoinType::BITCOIN);

        return redirect()->route('btcPages', $randomPage->getPageNumber());
    }

    public function invalidPage()
    {
        return 'invalid page yo';
    }
}
