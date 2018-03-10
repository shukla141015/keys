<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RedirectServiceProvider extends ServiceProvider
{
    protected $redirects = [
        // (old) url     destination route name
        '/btc' => 'btcPages',
    ];

    public function boot()
    {
        foreach ($this->redirects as $url => $destinationRouteName) {
            Route::any($url, function () use ($destinationRouteName) {
                return redirect()->route($destinationRouteName)->setStatusCode(301);
            });
        }
    }

    public function register()
    {

    }
}
