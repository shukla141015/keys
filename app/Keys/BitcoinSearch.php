<?php

namespace App\Keys;

use App\Http\Rules\ValidBitcoinWif;
use RuntimeException;

class BitcoinSearch
{
    private $pageNumber;

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

    public function pageNumber()
    {
        if (! $this->valid()) {
            throw new RuntimeException();
        }

        return $this->pageNumber;
    }

    public function valid()
    {
        return $this->pageNumber !== null;
    }
}
