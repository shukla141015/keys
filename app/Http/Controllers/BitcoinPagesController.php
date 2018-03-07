<?php

namespace App\Http\Controllers;

use App\Crypto\BitcoinPageNumber;
use App\Models\BtcPage;

class BitcoinPagesController extends Controller
{
    public function index($pageNumber = null)
    {
        $btcPageNumber = new BitcoinPageNumber($pageNumber);

        if ($btcPageNumber->shouldRedirect()) {
            return $btcPageNumber->redirect();
        }

        $btcPage = BtcPage::findByPageNumber($pageNumber);

        return view('bitcoin-page', [
            'pageNumber'          => $pageNumber,
            'isShortNumberString' => $btcPageNumber->isShortNumberString(),
            'isSmallNumber'       => $btcPageNumber->isSmallNumber(),
            'seenBefore'          => (bool) $btcPage,
            'lastSeen'            => $btcPage ? $btcPage->updated_at->format('U') : null,
            'wasEmpty'            => $btcPage->empty ?? null,
        ]);
    }

    public function invalidPage()
    {
        return 'invalid page yo';
    }
}
