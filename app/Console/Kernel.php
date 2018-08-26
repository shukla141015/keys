<?php

namespace App\Console;

use App\Jobs\GenerateSitemapJob;
use App\Models\CoinStats;
use App\Support\Enums\CoinType;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        foreach (CoinType::all() as $coin) {
            $schedule->call([CoinStats::class, 'today'], [$coin])->twiceDaily();
        }

        $schedule->job(GenerateSitemapJob::class)->dailyAt('1:03');

        // $schedule->command('backup:run-configless --disable-notifications --only-db --set-destination-disks=dropbox')->dailyAt('2:10');
    }
}
