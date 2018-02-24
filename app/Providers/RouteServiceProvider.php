<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        //

        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminWebRoutes();

        //
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web-routes.php'));
    }

    protected function mapAdminWebRoutes()
    {
        Route::prefix('admin')
             ->name('admin.')
             ->middleware(['web', 'auth'])
             ->namespace($this->namespace.'\\Admin')
             ->group(base_path('routes/web-admin-routes.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api/v1')
             ->middleware('api')
             ->name('api.')
             ->namespace($this->namespace.'\\Api')
             ->group(base_path('routes/api-routes.php'));
    }
}
