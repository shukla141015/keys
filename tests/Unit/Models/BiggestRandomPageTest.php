<?php

namespace Tests\Unit\Models;

use App\Models\BiggestRandomPage;
use App\Support\Enums\CoinType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BiggestRandomPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_lists_biggest_random_pages_for_a_specific_coin()
    {
        $this->createBiggestRandomPage(CoinType::BITCOIN,  '2018-01-01 12:00:00', '1000');
        $this->createBiggestRandomPage(CoinType::ETHEREUM, '2018-01-01 13:00:00', '1500');
        $this->createBiggestRandomPage(CoinType::BITCOIN,  '2018-01-01 14:00:00', '2500');
        $this->createBiggestRandomPage(CoinType::BITCOIN,  '2018-01-01 14:00:00', '2000'); // same timestamp, wrong order

        $items = BiggestRandomPage::listForCoin(CoinType::BITCOIN)
            ->pluck('created_at', 'page_number')
            ->map(function ($value) {
                return (string) $value;
            })
            ->all();

        $this->assertSame([
            '2500' => '2018-01-01 14:00:00',
            '2000' => '2018-01-01 14:00:00',
            '1000' => '2018-01-01 12:00:00',
        ], $items);
    }

    /** @test */
    function it_lists_biggest_random_pages_for_all_coins()
    {
        $this->createBiggestRandomPage(CoinType::BITCOIN,  '2018-09-03 17:45:00', '520');
        $this->createBiggestRandomPage(CoinType::ETHEREUM, '2018-09-03 19:15:00', '510');
        $this->createBiggestRandomPage(CoinType::ETHEREUM, '2018-09-03 20:31:00', '520');
        $this->createBiggestRandomPage(CoinType::BITCOIN,  '2018-09-04 15:27:00', '530');
        $this->createBiggestRandomPage(CoinType::ETHEREUM, '2018-09-04 16:38:00', '540');
        $this->createBiggestRandomPage(CoinType::BITCOIN,  '2018-09-05 07:51:00', '535');
        $this->createBiggestRandomPage(CoinType::ETHEREUM, '2018-09-06 23:43:00', '550');
        $this->createBiggestRandomPage(CoinType::BITCOIN,  '2018-09-09 23:42:00', '545');


        $items = BiggestRandomPage::listForAllCoins()
            ->map(function (BiggestRandomPage $page) {
                return [$page->coin, (string) $page->created_at, $page->page_number,];
            })
            ->all();

        $this->assertSame([
            [CoinType::ETHEREUM, '2018-09-06 23:43:00', '550'],
            [CoinType::ETHEREUM, '2018-09-04 16:38:00', '540'],
            [CoinType::BITCOIN,  '2018-09-04 15:27:00', '530'],
            [CoinType::BITCOIN,  '2018-09-03 17:45:00', '520'],
        ], $items);
    }

    private function createBiggestRandomPage($coin, $createdAt, $pageNumber)
    {
        return BiggestRandomPage::create([
            'coin' => $coin,
            'page_number' => $pageNumber,
            'created_at' => $createdAt,
        ]);
    }
}
