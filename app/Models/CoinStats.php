<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CoinStats extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'random_pages_generated' => 'integer',
        'pages_viewed'           => 'integer',
        'keys_generated'         => 'integer',
    ];

    public static function today($coin)
    {
        return static::firstOrCreate([
            'date' => now()->format('Y-m-d'),
            'coin' => $coin,
        ], [
            'random_pages_generated' => 0,
            'pages_viewed'           => 0,
            'keys_generated'         => 0,
        ]);
    }

    public static function randomPageGenerated($coin)
    {
        static::today($coin)->increment('random_pages_generated');
    }

    public static function coinPageViewed($coin, int $keysGenerated)
    {
        $today = static::today($coin);

        DB::table('coin_stats')
            ->where('id', $today->id)
            ->update([
                'pages_viewed'   => DB::raw('pages_viewed + 1'),
                'keys_generated' => DB::raw("keys_generated + $keysGenerated"),
            ]);
    }
}
