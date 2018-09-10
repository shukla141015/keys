<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BiggestRandomPage extends Model
{
    protected $guarded = [];

    public static function biggest($coin)
    {
        $model = static::query()
            ->select('page_number')
            ->where('coin', $coin)
            ->orderByDesc('id')
            ->first();

        return $model ? $model->page_number : '0';
    }

    public static function listForCoin($coinType): Collection
    {
        return static::query()
            ->select('coin', 'page_number', 'created_at')
            ->where('coin', $coinType)
            ->get()
            ->sortByDesc('page_number')
            ->values();
    }

    public static function listForAllCoins(): Collection
    {
        $biggestPages = static::query()
            ->select('coin', 'page_number', 'created_at')
            ->orderBy('created_at')
            ->get();

        $count = count($biggestPages);

        $biggestPageSoFar = '0';

        for ($i = 0; $i < $count; $i++) {
            if ($biggestPages[$i]->page_number > $biggestPageSoFar) {
                $biggestPageSoFar = $biggestPages[$i]->page_number;
            } else {
                $biggestPages->offsetUnset($i);
            }
        }

        return $biggestPages->reverse()->values();
    }
}
