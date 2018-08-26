<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::pattern('pageNumber', '\d+');
    }

    public function register()
    {
        //
    }
}
