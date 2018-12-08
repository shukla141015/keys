<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CoinStats extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'random_pages_generated' => 'int',
        'pages_viewed' => 'int',
        'keys_generated' => 'int',
        'times_searched' => 'int',
    ];

    public static function today($coin)
    {
        return static::firstOrCreate([
            'date' => now()->format('Y-m-d'),
            'coin' => $coin,
        ], [
            'random_pages_generated' => 0,
            'pages_viewed' => 0,
            'keys_generated' => 0,
            'times_searched' => 0,
        ]);
    }

    public static function randomPageGenerated($coin)
    {
        if (static::maybeNoModelYet()) {
            static::today($coin);
        }

        static::where([
                'date' => now()->format('Y-m-d'),
                'coin' => $coin,
            ])
            ->increment('random_pages_generated');
    }

    public static function coinPageViewed($coin, int $keysGenerated)
    {
        if (static::maybeNoModelYet()) {
            static::today($coin);
        }

        DB::table('coin_stats')
            ->where([
                'date' => now()->format('Y-m-d'),
                'coin' => $coin,
            ])
            ->update([
                'pages_viewed'   => DB::raw('pages_viewed + 1'),
                'keys_generated' => DB::raw("keys_generated + $keysGenerated"),
            ]);
    }

    public static function privateKeySearched($coin)
    {
        if (static::maybeNoModelYet()) {
            static::today($coin);
        }

        static::where([
                'date' => now()->format('Y-m-d'),
                'coin' => $coin,
            ])
            ->increment('times_searched');
    }

    /**
     * To prevent a database query per request, only create the CoinStats model
     * in the first few minutes of the day.
     *
     * The cron should also create the model when a new day starts.
     *
     * @return bool
     */
    private static function maybeNoModelYet()
    {
        return in_array(now()->format('H:i'), ['00:00', '00:01', '00:02']);
    }

    public static function combine(Collection $stats)
    {
        return (object) [
            'random_pages_generated' => $stats->sum->random_pages_generated,
            'pages_viewed' => $stats->sum->pages_viewed,
            'keys_generated' => $stats->sum->keys_generated,
            'times_searched' => $stats->sum->times_searched,
        ];
    }
}
