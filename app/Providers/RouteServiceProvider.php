<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function map()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web-routes.php'));

        if (app()->environment('local')) {
            $this->registerTestApiRoutes();
        }
    }

    private function registerTestApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api/v1')
            ->group(base_path('routes/api-test-routes.php'));
    }
}
