<?php

namespace App\Jobs;

use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemapJob extends BaseJob
{
    public function handle()
    {
        $applicationUrl = config('app.url');

        $sitemapFilePath = public_path('sitemap.xml');

        $sitemapGenerator = SitemapGenerator::create($applicationUrl);

        // Setting the maximum pages crawled will prevent some damage if we
        // ever make a mistake with "robots: noindex".
        $sitemapGenerator->setMaximumCrawlCount(50);

        $sitemapGenerator->writeToFile($sitemapFilePath);
    }
}
