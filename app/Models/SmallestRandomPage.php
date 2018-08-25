<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
