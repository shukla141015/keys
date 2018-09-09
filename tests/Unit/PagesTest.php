<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function pages_work()
    {
        $this->seed();

        $this->get(route('about'))->assertStatus(200);
        $this->get(route('stats'))->assertStatus(200);
    }
}
