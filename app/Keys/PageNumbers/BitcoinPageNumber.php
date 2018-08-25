<?php

namespace App\Keys\PageNumbers;

use App\Support\Enums\CoinType;
use Illuminate\Http\RedirectResponse;

class BitcoinPageNumber extends PageNumber
{
    public static $coin = CoinType::BITCOIN;

    protected function validatePageNumber($pageNumber): ?RedirectResponse
    {
        if ($pageNumber === null) {
            return redirect()->route('btcPages', 1);
        }

        if (! preg_match('/^\d+$/', $pageNumber)) {
            return redirect()->route('btcPages', 1);
        }

        $actualNumber = ltrim($pageNumber, '0');

        // Redirect if the "pageNumber" was all zeroes
        if ($actualNumber === '') {
            return redirect()->route('btcPages', 1);
        }

        // Redirect zero padded page numbers to non-padded page numbers.
        if ($actualNumber !== $pageNumber) {
            return redirect()->route('btcPages', $actualNumber);
        }

        // TODO: redirect numbers that are too large to a special error page.
        if ($pageNumber > static::lastPageNumber()) {
            return redirect()->route('btcPages', 1);
        }

        return null;
    }
}
