<?php

namespace App\Console;

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

        // $schedule->command('sitemap:generate')->dailyAt('2:00');
    }
}
