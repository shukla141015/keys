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

    public static function combine($stats)
    {
        $object = new class implements \ArrayAccess {
            public $random_pages_generated = 0;
            public $pages_viewed = 0;
            public $keys_generated = '0';

            public function offsetExists($offset)
            {
                return in_array($offset, ['random_pages_generated', 'pages_viewed', 'keys_generated']);
            }

            public function offsetGet($offset)
            {
                if (! $this->offsetExists($offset)) {
                    throw new \RuntimeException();
                }

                return $this->{$offset};
            }

            public function offsetSet($offset, $value)
            {
                throw new \RuntimeException();
            }

            public function offsetUnset($offset)
            {
                throw new \RuntimeException();
            }
        };

        foreach ($stats as $stat) {
            $object->random_pages_generated += $stat->random_pages_generated;

            $object->pages_viewed += $stat->pages_viewed;

            $object->keys_generated = string_add($object->keys_generated, (string) $stat->keys_generated);
        }

        return $object;
    }
}
