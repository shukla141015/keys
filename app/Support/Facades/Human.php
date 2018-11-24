<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void verifyCurrentUser()
 * @method static boolean isReal()
 * @method static void putRedirectUrl($url)
 * @method static string pullRedirectUrl()
 */
class Human extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'human-verification';
    }
}
