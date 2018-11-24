<?php

namespace Tests\Unit\Models;

use App\Models\CoinStats;
use App\Support\Enums\CoinType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinStatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_combines_coin_stats_models()
    {
        $stat1 = CoinStats::create([
            'date' => '2018-09-15',
            'coin' => 'btc',
            'random_pages_generated' => 100,
            'pages_viewed' => 200,
            'keys_generated' => 300,
        ]);

        $stat2 = CoinStats::create([
            'date' => '2018-09-16',
            'coin' => 'btc',
            'random_pages_generated' => 10,
            'pages_viewed' => 20,
            'keys_generated' => 30,
        ]);

        $stat3 = CoinStats::create([
            'date' => '2018-09-17',
            'coin' => 'eth',
            'random_pages_generated' => 1,
            'pages_viewed' => 2,
            'keys_generated' => 3,
        ]);

        $collection = collect([$stat1, $stat2, $stat3]);

        $combined = CoinStats::combine($collection);

        $this->assertSame(111, $combined->random_pages_generated);
        $this->assertSame(222, $combined->pages_viewed);
        $this->assertSame(333, $combined->keys_generated);
    }

    /** @test */
    function it_can_combine_an_empty_collection()
    {
        $collection = collect();

        $combined = CoinStats::combine($collection);

        $this->assertSame(0, $combined->random_pages_generated);
        $this->assertSame(0, $combined->pages_viewed);
        $this->assertSame(0, $combined->keys_generated);
    }

    /** @test */
    function it_creates_a_model_when_there_might_not_be_one()
    {
        Carbon::setTestNow('2018-05-15 00:30');

        $this->assertSame(0, CoinStats::count());

        // It doesn't create a model because there should already be one.
        CoinStats::randomPageGenerated(CoinType::BITCOIN);
        $this->assertSame(0, CoinStats::count());

        // There might not be a model, so it creates one
        Carbon::setTestNow('2018-05-15 00:00');
        CoinStats::randomPageGenerated(CoinType::BITCOIN);
        $this->assertSame(1, CoinStats::count());

        CoinStats::query()->delete();
        $this->assertSame(0, CoinStats::count());

        Carbon::setTestNow('2018-05-15 00:00');
        CoinStats::coinPageViewed(CoinType::BITCOIN, 128);
        $this->assertSame(1, CoinStats::count());

        //
        //

        CoinStats::query()->delete();

        Carbon::setTestNow('2018-05-16 00:01');
        CoinStats::randomPageGenerated(CoinType::BITCOIN);
        $this->assertSame(1, CoinStats::count());
    }
}
