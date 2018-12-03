<?php

namespace App\Http\Controllers;

use App\Http\Rules\ValidBitcoinWif;
use App\Keys\BitcoinPageKeys;
use App\Keys\BitcoinSearch;
use App\Keys\PageNumbers\BitcoinPageNumber;
use App\Support\Enums\CoinType;

class BitcoinPagesController extends KeyPagesController
{
    protected $coinType = CoinType::BITCOIN;

    protected $pageNumber = BitcoinPageNumber::class;

    protected $pageKeys = BitcoinPageKeys::class;

    protected $privateKeyRule = ValidBitcoinWif::class;

    protected $coinSearch = BitcoinSearch::class;
}
