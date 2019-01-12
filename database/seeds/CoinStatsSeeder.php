<?php

use App\Models\CoinStats;
use App\Support\Enums\CoinType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CoinStatsSeeder extends Seeder
{
    public function run()
    {
        $startDate = now()->subDays(14);

        $now = now();

        while ($startDate->lessThan($now)) {
            $this->seed($startDate);

            $startDate->addDays(1);
        }
    }

    protected function seed(Carbon $date)
    {
        CoinType::all()->each(function ($coinType) use ($date) {
            CoinStats::create([
                'coin' => $coinType,
                'date' => $date->toDateString(),
                'pages_viewed' => $pagesViewed = random_int(0, 100000),
                'random_pages_generated' => random_int(0, $pagesViewed),
                'keys_generated' => $pagesViewed * 128,
            ]);
        });
    }
}
