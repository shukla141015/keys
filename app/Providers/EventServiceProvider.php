<?php

namespace App\Providers;

use App\Events\RandomPageGenerated;
use App\Listeners\RecordBiggestPage;
use App\Listeners\RecordSmallestPage;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

       RandomPageGenerated::class => [
           RecordSmallestPage::class,
           RecordBiggestPage::class,
       ],

    ];
}
