<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemapJob extends BaseJob implements ShouldQueue
{
    public function handle()
    {
        $applicationUrl = config('app.url');

        $sitemapFilePath = public_path('sitemap.xml');

        // Setting the maximum pages crawled will prevent some damage if we
        // ever make a mistake with "robots: noindex".
        SitemapGenerator::create($applicationUrl)
            ->setMaximumCrawlCount(50)
            ->writeToFile($sitemapFilePath);
    }
}
