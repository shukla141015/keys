<?php

namespace App\Http\Controllers;

use App\Keys\PageNumbers\BitcoinPageNumber;
use App\Models\BiggestRandomPage;
use App\Models\CoinStats;
use App\Models\SmallestRandomPage;
use Illuminate\Routing\Controller as BaseController;

class StatisticsPageController extends BaseController
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
            'smallestPages' => $this->smallestPages(),
            'biggestPages'  => $this->biggestPages(),
            'maxPage' => BitcoinPageNumber::lastPageNumber(),
        ]);
    }

    protected function smallestPages()
    {
        $smallestPages = SmallestRandomPage::query()
            ->select('coin', 'page_number', 'created_at')
            ->get()
            ->sort(function ($a, $b) {
                // sort big to small
                return $b->page_number <=> $a->page_number;
            })
            ->all();

        if (! $smallestPages) {
            return [];
        }

        $currentSmallest = BitcoinPageNumber::lastPageNumber();

        $filtered = [];

        foreach ($smallestPages as $smallestPage) {
            if ($smallestPage->page_number < $currentSmallest) {
                $filtered[] = $smallestPage;

                $currentSmallest = $smallestPage->page_number;
            }
        }

        return array_reverse($filtered);
    }

    protected function biggestPages()
    {
        $biggestPages = BiggestRandomPage::query()
            ->select('coin', 'page_number', 'created_at')
            ->get()
            ->sort(function ($a, $b) {
                // sort small to big
                return $a->page_number <=> $b->page_number;
            })
            ->all();

        if (! $biggestPages) {
            return [];
        }

        $currentBiggest = '0';

        $filtered = [];

        foreach ($biggestPages as $biggestPage) {
            if ($biggestPage->page_number > $currentBiggest) {
                $filtered[] = $biggestPage;

                $currentBiggest = $biggestPage->page_number;
            }
        }

        return array_reverse($filtered);
    }
}
