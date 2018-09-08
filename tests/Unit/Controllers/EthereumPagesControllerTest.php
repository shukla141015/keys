<?php

namespace Tests\Unit\Controllers;

use App\Events\RandomPageGenerated;
use App\Keys\PageNumbers\EthereumPageNumber;
use App\Models\BiggestRandomPage;
use App\Models\CoinStats;
use App\Models\SmallestRandomPage;
use App\Support\Enums\CoinType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EthereumPagesControllerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    function it_can_show_the_index()
    {
        $this->get(route('ethPages.index'))
            ->assertStatus(200);
    }

    /** @test */
    function it_can_show_the_first_page()
    {
        $this->getPage('1')
            ->assertStatus(200)
            ->assertDontSee('noindex'); // first page should be indexed by robots.
    }

    /** @test */
    function it_can_show_the_last_page()
    {
        $this->getPage(EthereumPageNumber::lastPageNumber())
            ->assertStatus(200)
            ->assertDontSee('noindex'); // first page should be indexed by robots.
    }

    /** @test */
    function it_can_show_a_random_page()
    {
        $this->expectsEvents(RandomPageGenerated::class);

        $this->assertSame(0, CoinStats::today(CoinType::ETHEREUM)->random_pages_generated);

        $this->followingRedirects()
            ->getRandomPage()
            ->assertStatus(200)
            ->assertViewIs('eth-page')
            ->assertSee('<meta name="robots" content="noindex, nofollow">');

        $this->assertSame(1, CoinStats::today(CoinType::ETHEREUM)->random_pages_generated);
    }

    /** @test */
    function you_get_redirected_when_exceeding_the_max_page_number()
    {
        $this->followingRedirects()
            ->getPage(EthereumPageNumber::lastPageNumber().'1234')
            ->assertStatus(200)
            ->assertViewIs('eth-page-too-big');
    }

    /** @test */
    function it_keeps_track_of_page_views_stats()
    {
        $this->assertSame(0, CoinStats::today(CoinType::ETHEREUM)->pages_viewed);
        $this->assertSame(0, CoinStats::today(CoinType::ETHEREUM)->keys_generated);

        $this->getPage('123456')->assertStatus(200);

        $this->assertSame(1, CoinStats::today(CoinType::ETHEREUM)->pages_viewed);
        $this->assertSame(128, CoinStats::today(CoinType::ETHEREUM)->keys_generated);

        $this->getPage(EthereumPageNumber::lastPageNumber())->assertStatus(200);

        $this->assertSame(2, CoinStats::today(CoinType::ETHEREUM)->pages_viewed);
        $this->assertSame(224, CoinStats::today(CoinType::ETHEREUM)->keys_generated);
    }

    /** @test */
    function biggest_and_smallest_random_bitcoin_page_get_stored()
    {
        $redirectUrl = $this->getRandomPage()
            ->assertStatus(302)
            ->headers
            ->get('location');

        $randomNumber = last(explode('/', $redirectUrl));

        $this->assertTrue(strlen($randomNumber) > 10);

        $this->assertSame(1, SmallestRandomPage::count());
        $this->assertSame($randomNumber, SmallestRandomPage::smallest(CoinType::ETHEREUM));

        $this->assertSame(1, BiggestRandomPage::count());
        $this->assertSame($randomNumber, BiggestRandomPage::biggest(CoinType::ETHEREUM));
    }

    /** @test */
    function it_stores_the_new_smallest_number()
    {
        SmallestRandomPage::create([
            'coin' => CoinType::ETHEREUM,
            'page_number' => '519480938980827735392876',
        ]);

        RandomPageGenerated::dispatch(
            new EthereumPageNumber('519480938980827735392877')
        );

        $this->assertSame(1, SmallestRandomPage::count());

        RandomPageGenerated::dispatch(
            new EthereumPageNumber('99948093898')
        );

        $this->assertSame(2, SmallestRandomPage::count());

        $this->assertSame('99948093898', SmallestRandomPage::smallest(CoinType::ETHEREUM));
    }

    /** @test */
    function it_stores_the_new_biggest_number()
    {
        SmallestRandomPage::create([
            'coin' => CoinType::ETHEREUM,
            'page_number' => '519480938980827735392876',
        ]);

        RandomPageGenerated::dispatch(
            new EthereumPageNumber('519480938980827735392875')
        );

        $this->assertSame(1, BiggestRandomPage::count());

        RandomPageGenerated::dispatch(
            new EthereumPageNumber('519480938980827735392877')
        );

        $this->assertSame(2, BiggestRandomPage::count());

        $this->assertSame('519480938980827735392877', BiggestRandomPage::biggest(CoinType::ETHEREUM));
    }

    private function getPage($number)
    {
        return $this->get(route('ethPages', $number));
    }

    private function getRandomPage()
    {
        return $this->get(route('ethPages.random'));
    }
}
