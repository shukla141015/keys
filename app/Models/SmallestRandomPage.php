<?php

namespace App\Models;

use App\Keys\PageNumbers\PageNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SmallestRandomPage extends Model
{
    protected $guarded = [];

    public static function smallest($coin)
    {
        $model = static::query()
            ->select('page_number')
            ->where('coin', $coin)
            ->orderByDesc('id')
            ->first();

        return $model ? $model->page_number : config("keys.$coin.max_page");
    }

    public static function listForCoin($coinType): Collection
    {
        return static::query()
            ->select('coin', 'page_number', 'created_at')
            ->where('coin', $coinType)
            ->orderBy('page_number')
            ->get();
    }

    public static function listForAllCoins(): Collection
    {
        $smallestPages = static::query()
            ->select('coin', 'page_number', 'created_at')
            ->orderBy('created_at')
            ->get();

        $count = count($smallestPages);

        $smallestPageSoFar = PageNumber::lastPageNumber();

        for ($i = 0; $i < $count; $i++) {
            if ($smallestPages[$i]->page_number < $smallestPageSoFar) {
                $smallestPageSoFar = $smallestPages[$i]->page_number;
            } else {
                $smallestPages->offsetUnset($i);
            }
        }

        return $smallestPages->reverse()->values();
    }
}
