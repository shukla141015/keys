<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
       // Event::class => [
       //     Listener::class,
       // ],
    ];

    public function boot()
    {
        parent::boot();


    }
}
