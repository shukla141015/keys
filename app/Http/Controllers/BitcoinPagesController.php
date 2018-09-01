<?php

namespace App\Http\Controllers;

use App\Keys\BitcoinPageKeys;
use App\Keys\PageNumbers\BitcoinPageNumber;
use App\Support\Enums\CoinType;

class BitcoinPagesController extends KeyPagesController
{
    protected $coinType = CoinType::BITCOIN;

    protected $pageNumber = BitcoinPageNumber::class;

    protected $pageKeys = BitcoinPageKeys::class;
}
