<?php

namespace App\Http\Controllers;

use App\Events\RandomPageGenerated;
use App\Keys\BitcoinPageKeys;
use App\Keys\PageNumbers\BitcoinPageNumber;

class BitcoinPagesController extends Controller
{
    public function index($pageNumber = null)
    {
        $btcPageNumber = new BitcoinPageNumber($pageNumber);

        if ($btcPageNumber->shouldRedirect()) {
            return $btcPageNumber->redirect();
        }

        $keys = BitcoinPageKeys::generate($pageNumber);

        return view('bitcoin-page', [
            'pageNumber'          => $pageNumber,
            'nextPage'            => increment_string($pageNumber),
            'previousPage'        => decrement_string($pageNumber),
            'lastPage'            => $btcPageNumber->lastPageNumber(),
            'isOnFirstPage'       => $pageNumber === '1',
            'isOnLastPage'        => $pageNumber === $btcPageNumber->lastPageNumber(),
            'isShortNumberString' => $btcPageNumber->isShortNumberString(),
            'isSmallNumber'       => $btcPageNumber->isSmallNumber(),
            'keys'                => json_encode($keys),
        ]);
    }

    public function randomPage()
    {
        $randomPage = BitcoinPageNumber::random();

        RandomPageGenerated::dispatch($randomPage);

        return redirect()->route('btcPages', $randomPage->getPageNumber());
    }

    public function invalidPage()
    {
        return 'invalid page yo';
    }
}
