<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    protected $guarded = [];

    public static function isReal($sessionId = null)
    {
        $sessionId = $sessionId ?: session()->getId();

        return self::query()->where('session_id', $sessionId)->exists();
    }
}
