<?php

namespace App\Keys\Search;

use App\Http\Rules\ValidEthereumPrivateKey;
use App\Keys\PageNumbers\EthereumPageNumber;

class EthereumSearch extends CoinSearch
{
    public function __construct(string $pk)
    {
        $valid = (new ValidEthereumPrivateKey)->passes('wif', $pk);

        if (! $valid) {
            return;
        }

        $output = shell_exec('keys-generator eth-search '.$pk);

        $ethPage = new EthereumPageNumber($output);

        if ($ethPage->isValid()) {
            $this->pageNumber = $output;
        }
    }
}
