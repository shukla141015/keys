<?php

namespace App\Http\Controllers;

use App\Http\Rules\ValidEthereumPrivateKey;
use App\Keys\EthereumPageKeys;
use App\Keys\PageNumbers\EthereumPageNumber;
use App\Keys\Search\EthereumSearch;
use App\Support\Enums\CoinType;

class EthereumPagesController extends KeyPagesController
{
    protected $coinType = CoinType::ETHEREUM;

    protected $pageNumber = EthereumPageNumber::class;

    protected $pageKeys = EthereumPageKeys::class;

    protected $privateKeyRule = ValidEthereumPrivateKey::class;

    protected $coinSearch = EthereumSearch::class;
}
