<?php

namespace App\Keys\PageNumbers;

use App\Support\Enums\CoinType;

class EthereumPageNumber extends PageNumber
{
    public static $coin = CoinType::ETHEREUM;

    protected static $robotAllowedPages = [
        '1',
        '2',
        '3',
        '904625697166532776746648320380374280100293470930272690489102837043110636673',
        '904625697166532776746648320380374280100293470930272690489102837043110636674',
        '904625697166532776746648320380374280100293470930272690489102837043110636675',
    ];
}
