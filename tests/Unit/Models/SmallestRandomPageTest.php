<?php

namespace Tests\Unit\Models;

use App\Models\SmallestRandomPage;
use App\Support\Enums\CoinType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmallestRandomPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_lists_smallest_random_pages_for_a_specific_coin()
    {
        $this->createSmallestRandomPage(CoinType::BITCOIN,  '2018-01-01 12:00:00', '129167182412113078264578878358415493192234440125820083044022746837078656714');
        $this->createSmallestRandomPage(CoinType::ETHEREUM, '2018-01-01 13:00:00', '26604748956824335586991504766000556433843609561099762271114670491157758127');
        $this->createSmallestRandomPage(CoinType::BITCOIN,  '2018-01-01 14:00:00', '147177945788279615438618196920904662741326648432603055013699237916865605');
        // same timestamp, wrong order
        $this->createSmallestRandomPage(CoinType::BITCOIN,  '2018-01-01 14:00:00', '10642809896122618337985045895423291139736629195921279261055765675170133');

        $items = SmallestRandomPage::listForCoin(CoinType::BITCOIN)
            ->pluck('created_at', 'page_number')
            ->map(function ($value) {
                return (string) $value;
            })
            ->all();

        $this->assertSame([
            '10642809896122618337985045895423291139736629195921279261055765675170133'     => '2018-01-01 14:00:00',
            '147177945788279615438618196920904662741326648432603055013699237916865605'    => '2018-01-01 14:00:00',
            '129167182412113078264578878358415493192234440125820083044022746837078656714' => '2018-01-01 12:00:00',
        ], $items);
    }

    /** @test */
    function it_lists_smallest_random_pages_for_all_coins()
    {
        $this->createSmallestRandomPage(CoinType::ETHEREUM, '2018-09-06 23:43:00', '520');
        $this->createSmallestRandomPage(CoinType::BITCOIN,  '2018-09-09 23:42:00', '500');
        $this->createSmallestRandomPage(CoinType::ETHEREUM, '2018-09-06 00:09:00', '530');
        $this->createSmallestRandomPage(CoinType::BITCOIN,  '2018-09-05 07:51:00', '520');
        $this->createSmallestRandomPage(CoinType::ETHEREUM, '2018-09-04 16:39:00', '540');
        $this->createSmallestRandomPage(CoinType::ETHEREUM, '2018-09-04 16:38:00', '550');
        $this->createSmallestRandomPage(CoinType::BITCOIN,  '2018-09-04 15:27:00', '560');
        $this->createSmallestRandomPage(CoinType::ETHEREUM, '2018-09-03 20:31:00', '570');
        $this->createSmallestRandomPage(CoinType::ETHEREUM, '2018-09-03 19:15:00', '580');
        $this->createSmallestRandomPage(CoinType::BITCOIN,  '2018-09-03 17:45:00', '555');

        $items = SmallestRandomPage::listForAllCoins()
            ->map(function (SmallestRandomPage $page) {
                return [$page->coin, (string) $page->created_at, $page->page_number,];
            })
            ->all();

        $this->assertSame([
            [CoinType::BITCOIN,  '2018-09-09 23:42:00', '500'],
            [CoinType::BITCOIN,  '2018-09-05 07:51:00', '520'],
            [CoinType::ETHEREUM, '2018-09-04 16:39:00', '540'],
            [CoinType::ETHEREUM, '2018-09-04 16:38:00', '550'],
            [CoinType::BITCOIN,  '2018-09-03 17:45:00', '555'],
        ], $items);
    }

    private function createSmallestRandomPage($coin, $createdAt, $pageNumber)
    {
        return SmallestRandomPage::create([
            'coin' => $coin,
            'page_number' => $pageNumber,
            'created_at' => $createdAt,
        ]);
    }
}
