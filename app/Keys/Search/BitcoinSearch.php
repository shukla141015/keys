<?php

namespace App\Keys\Search;

use App\Http\Rules\ValidBitcoinWif;

class BitcoinSearch extends CoinSearch
{
    public function __construct(string $wif)
    {
        $validWif = (new ValidBitcoinWif)->passes('wif', $wif);

        if (! $validWif) {
            return;
        }

        $output = shell_exec('keys-generator btc-search '.$wif);

        if (preg_match('/^\d+$/', $output)) {
            $this->pageNumber = $output;
        }
    }
}
