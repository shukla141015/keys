<?php

namespace App\Providers;

use App\Keys\Human;
use Illuminate\Routing\Middleware\ThrottleRequests;
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
        $this->app->singleton('human-verification', function () {
            return new Human();
        });

        // This is a hack to get the SitemapGenerator to work
        // correctly when running unit tests.
        //
        // See: "tests/PagesTest.php"
        if ($this->app->environment() === 'testing') {
            $this->app->instance(ThrottleRequests::class, new class {
                public function handle($request, $next)
                {
                    return $next($request);
                }
            });
        }
    }
}
