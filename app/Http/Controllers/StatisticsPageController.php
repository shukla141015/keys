<?php

namespace App\Http\Controllers;

use App\Keys\PageNumbers\PageNumber;
use App\Models\BiggestRandomPage;
use App\Models\CoinStats;
use App\Models\SmallestRandomPage;

class StatisticsPageController
{
    public function __invoke()
    {
        $allTime = CoinStats::query()
            ->select('date', 'random_pages_generated', 'pages_viewed', 'keys_generated')
            ->get();

        $dateCurrentMonth = now()->format('-m-');

        $thisMonth = $allTime->filter(function (CoinStats $coinStats) use ($dateCurrentMonth) {
            return strpos($coinStats->date, $dateCurrentMonth) !== false;
        });

        $dateLastMonth = now()->startOfMonth()->subDays(1)->format('-m-');

        $lastMonth = $allTime->filter(function (CoinStats $coinStats) use ($dateLastMonth) {
            return strpos($coinStats->date, $dateLastMonth) !== false;
        });

        return view('stats', [
            'today'     => CoinStats::combine($allTime->where('date', now()->toDateString())),
            'thisMonth' => CoinStats::combine($thisMonth),
            'lastMonth' => CoinStats::combine($lastMonth),
            'allTime'   => CoinStats::combine($allTime),
            'smallestPages' => SmallestRandomPage::listForAllCoins(),
            'biggestPages'  => BiggestRandomPage::listForAllCoins(),
            'maxPage' => PageNumber::lastPageNumber(),
        ]);
    }
}
