<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BtcPage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'empty' => 'boolean',
    ];

    /**
     * @param string $pageNumber
     *
     * @return BtcPage|null
     */
    public static function findByPageNumber(string $pageNumber)
    {
        return static::where(['page_number' => $pageNumber])->first();
    }
}
