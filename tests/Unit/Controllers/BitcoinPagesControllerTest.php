<?php

namespace Tests\Unit\Controllers;

use App\Events\RandomPageGenerated;
use App\Keys\PageNumbers\BitcoinPageNumber;
use App\Models\BiggestRandomPage;
use App\Models\CoinStats;
use App\Models\SmallestRandomPage;
use App\Support\Enums\CoinType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BitcoinPagesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_can_show_the_index()
    {
        $this->get(route('btcPages.index'))
            ->assertStatus(200);
    }

    /** @test */
    function it_can_show_stats()
    {
        $this->get(route('btcPages.stats'))
            ->assertStatus(200);
    }

    /** @test */
    function it_can_show_the_search_page()
    {
        $this->get(route('btcPages.search'))
            ->assertStatus(200);
    }

    /** @test */
    function it_can_search_for_a_bitcoin_wif()
    {
        $statsToday = CoinStats::today(CoinType::BITCOIN);

        $this->assertSame(0, $statsToday->times_searched);

        $this->post(route('btcPages.search'), [
                'private_key' => '5KAmCM5bmAW4zxLJtGMAQPGswXcpErraYvTcTRokC3DyCFRWwWV',
            ])
            ->assertSessionHasNoErrors()
            ->assertStatus(302)
            ->assertRedirect(route('btcPages', '629667647944995883434832701814245589852462714096679821861984176598252146907'));

        $this->assertSame(1, $statsToday->refresh()->times_searched);
    }

    /** @test */
    function it_wont_search_for_invalid_wifs()
    {
        $statsToday = CoinStats::today(CoinType::BITCOIN);

        $this->assertSame(0, $statsToday->times_searched);

        $this->postSearch(['private_key' => 'Hacked!!'])->assertSessionHasErrors('private_key');

        // shouldn't increment when the search fails
        $this->assertSame(0, $statsToday->refresh()->times_searched);
    }

    /** @test */
    function it_can_show_the_first_page()
    {
        $this->getPage('1')
            ->assertStatus(200)
            ->assertDontSee('noindex'); // first page should be indexed by robots.
    }

    /** @test */
    function some_pages_allow_robots()
    {
        $this->getPage('2')->assertStatus(200)->assertDontSee('noindex');
        $this->getPage('3')->assertStatus(200)->assertDontSee('noindex');
        $this->getPage('4')->assertStatus(200)->assertSee('noindex');

        $this->getPage('856083576414584832184365027012002209974486074049742179003044245104477177635')->assertStatus(200)->assertDontSee('noindex');
        $this->getPage('510237430825191857507550834203449025283598621334783813450916609258406994299')->assertStatus(200)->assertDontSee('noindex');
        $this->getPage('114229580830911906838372329972449433969860788497685910473052341467827083606')->assertStatus(200)->assertDontSee('noindex');

        $this->getPage('904625697166532776746648320380374280100293470930272690489102837043110636672')->assertStatus(200)->assertSee('noindex');
        $this->getPage('904625697166532776746648320380374280100293470930272690489102837043110636673')->assertStatus(200)->assertDontSee('noindex');
        $this->getPage('904625697166532776746648320380374280100293470930272690489102837043110636674')->assertStatus(200)->assertDontSee('noindex');
        $this->getPage('904625697166532776746648320380374280100293470930272690489102837043110636675')->assertStatus(200)->assertDontSee('noindex');
    }

    /** @test */
    function it_can_show_the_last_page()
    {
        $this->getPage(BitcoinPageNumber::lastPageNumber())
            ->assertStatus(200)
            ->assertDontSee('noindex'); // first page should be indexed by robots.
    }

    /** @test */
    function it_can_show_a_random_page()
    {
        $this->expectsEvents(RandomPageGenerated::class);

        $this->assertSame(0, CoinStats::today(CoinType::BITCOIN)->random_pages_generated);

        $this->followingRedirects()
            ->getRandomPage()
            ->assertStatus(200)
            ->assertViewIs('btc-page')
            ->assertSee('<meta name="robots" content="noindex, nofollow">');

        $this->assertSame(1, CoinStats::today(CoinType::BITCOIN)->random_pages_generated);
    }

    /** @test */
    function you_get_redirected_when_exceeding_the_max_page_number()
    {
        $this->followingRedirects()
            ->getPage(BitcoinPageNumber::lastPageNumber().'1234')
            ->assertStatus(200)
            ->assertViewIs('btc-page-too-big');
    }

    /** @test */
    function it_keeps_track_of_page_views_stats()
    {
        $this->assertSame(0, CoinStats::today(CoinType::BITCOIN)->pages_viewed);
        $this->assertSame(0, CoinStats::today(CoinType::BITCOIN)->keys_generated);

        $this->getPage('123456')->assertStatus(200);

        $this->assertSame(1, CoinStats::today(CoinType::BITCOIN)->pages_viewed);
        $this->assertSame(128, CoinStats::today(CoinType::BITCOIN)->keys_generated);

        $this->getPage(BitcoinPageNumber::lastPageNumber())->assertStatus(200);

        $this->assertSame(2, CoinStats::today(CoinType::BITCOIN)->pages_viewed);
        $this->assertSame(192, CoinStats::today(CoinType::BITCOIN)->keys_generated);
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
        $this->assertSame($randomNumber, SmallestRandomPage::smallest(CoinType::BITCOIN));

        $this->assertSame(1, BiggestRandomPage::count());
        $this->assertSame($randomNumber, BiggestRandomPage::biggest(CoinType::BITCOIN));
    }

    /** @test */
    function it_stores_the_new_smallest_number()
    {
        SmallestRandomPage::create([
            'coin' => CoinType::BITCOIN,
            'page_number' => '519480938980827735392876',
        ]);

        RandomPageGenerated::dispatch(
            new BitcoinPageNumber('519480938980827735392877')
        );

        $this->assertSame(1, SmallestRandomPage::count());

        RandomPageGenerated::dispatch(
            new BitcoinPageNumber('99948093898')
        );

        $this->assertSame(2, SmallestRandomPage::count());

        $this->assertSame('99948093898', SmallestRandomPage::smallest(CoinType::BITCOIN));
    }

    /** @test */
    function it_stores_the_new_biggest_number()
    {
        SmallestRandomPage::create([
            'coin' => CoinType::BITCOIN,
            'page_number' => '519480938980827735392876',
        ]);

        RandomPageGenerated::dispatch(
            new BitcoinPageNumber('519480938980827735392875')
        );

        $this->assertSame(1, BiggestRandomPage::count());

        RandomPageGenerated::dispatch(
            new BitcoinPageNumber('519480938980827735392877')
        );

        $this->assertSame(2, BiggestRandomPage::count());

        $this->assertSame('519480938980827735392877', BiggestRandomPage::biggest(CoinType::BITCOIN));
    }

    private function getPage($number)
    {
        return $this->get(route('btcPages', $number));
    }

    private function getRandomPage()
    {
        return $this->get(route('btcPages.random'));
    }

    private function postSearch($data)
    {
        return $this->post(route('btcPages.search'), $data);
    }
}
