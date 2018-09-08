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
        $this->get(route('about'))->assertStatus(200);
        $this->get(route('btcPages.index'))->assertStatus(200);
        $this->get(route('ethPages.index'))->assertStatus(200);
    }
}
