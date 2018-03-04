<?php

namespace App\Http\Controllers;

use App\Crypto\BitcoinPageNumber;

class BitcoinPagesController extends Controller
{
    public function index($pageNumber = null)
    {
        $btcPageNumber = new BitcoinPageNumber($pageNumber);

        if ($btcPageNumber->shouldRedirect()) {
            return $btcPageNumber->redirect();
        }

        return view('bitcoin-page', [
            'pageNumber'          => $btcPageNumber->getPageNumber(),
            'isShortNumberString' => $btcPageNumber->isShortNumberString(),
            'isSmallNumber'       => $btcPageNumber->isSmallNumber(),
        ]);
    }

    public function invalidPage()
    {
        return 'invalid page yo';
    }
}
