<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
