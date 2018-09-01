<?php

namespace App\Keys\PageNumbers;

use App\Support\Enums\CoinType;

class BitcoinPageNumber extends PageNumber
{
    public static $coin = CoinType::BITCOIN;
}
