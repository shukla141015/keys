<?php

namespace App\Console\Commands;

use App\Jobs\GenerateSitemapJob;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'keys:generate-sitemap';

    protected $description = 'Queue a job to generate a sitemap';

    public function handle()
    {
        GenerateSitemapJob::dispatch();
    }
}
