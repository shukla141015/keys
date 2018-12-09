<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Tag;
use Spatie\Sitemap\Tags\Url;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function pages_work()
    {
        $this->seed();

        $this->get(route('about'))->assertStatus(200);
        $this->get(route('stats'))->assertStatus(200);
    }

    /** @test */
    function it_generates_a_sitemap()
    {
        // There is a hack in "AppServiceProvider.php" to disable rate-throttling for this test

        $tags = SitemapGenerator::create(config('app.url'))
            ->setMaximumCrawlCount(5000)
            ->getSitemap()
            ->getTags();

        $urlTags = collect($tags)->filter(function (Tag $tag) {
            return $tag->getType() === 'url';
        });

        $this->assertSame(count($tags), count($urlTags));

        $urls = $urlTags->map(function (Url $tag) {
                return $tag->url;
            })
            ->sort()
            ->values()
            ->toArray();

        $this->assertSame([
            'http://keys.pk/',
            'http://keys.pk/about',
            'http://keys.pk/bitcoin',
            'http://keys.pk/bitcoin/1',
            'http://keys.pk/bitcoin/114229580830911906838372329972449433969860788497685910473052341467827083606',
            'http://keys.pk/bitcoin/2',
            'http://keys.pk/bitcoin/3',
            'http://keys.pk/bitcoin/510237430825191857507550834203449025283598621334783813450916609258406994299',
            'http://keys.pk/bitcoin/856083576414584832184365027012002209974486074049742179003044245104477177635',
            'http://keys.pk/bitcoin/904625697166532776746648320380374280100293470930272690489102837043110636673',
            'http://keys.pk/bitcoin/904625697166532776746648320380374280100293470930272690489102837043110636674',
            'http://keys.pk/bitcoin/904625697166532776746648320380374280100293470930272690489102837043110636675',
            'http://keys.pk/bitcoin/search',
            'http://keys.pk/ethereum',
            'http://keys.pk/ethereum/1',
            'http://keys.pk/ethereum/2',
            'http://keys.pk/ethereum/3',
            'http://keys.pk/ethereum/904625697166532776746648320380374280100293470930272690489102837043110636673',
            'http://keys.pk/ethereum/904625697166532776746648320380374280100293470930272690489102837043110636674',
            'http://keys.pk/ethereum/904625697166532776746648320380374280100293470930272690489102837043110636675',
            'http://keys.pk/ethereum/search',
            'http://keys.pk/statistics',
        ], $urls);
    }
}
