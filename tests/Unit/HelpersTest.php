<?php

namespace Tests\Unit;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    function it_increments_strings()
    {
        $this->assertSame('1',   increment_string('0'));
        $this->assertSame('6',   increment_string('5'));
        $this->assertSame('10',  increment_string('9'));
        $this->assertSame('100', increment_string('99'));
        $this->assertSame('101', increment_string('100'));

        $this->assertSame('272690489102837043110636675',  increment_string('272690489102837043110636674'));
        $this->assertSame('272690489102840000000000000',  increment_string('272690489102839999999999999'));
        $this->assertSame('1000000000000000000000000000', increment_string('999999999999999999999999999'));

        $maxInt = PHP_INT_MAX;
        $this->assertSame((string) PHP_INT_MAX,  increment_string((string) --$maxInt));
    }

    /** @test */
    function it_decrements_strings()
    {
        $this->assertSame('-1',  decrement_string('0'));
        $this->assertSame('0',   decrement_string('1'));
        $this->assertSame('6',   decrement_string('7'));
        $this->assertSame('9',   decrement_string('10'));
        $this->assertSame('99',  decrement_string('100'));
        $this->assertSame('100', decrement_string('101'));

        $this->assertSame('272690489102837043110636674',  decrement_string('272690489102837043110636675'));
        $this->assertSame('272690489102839999999999999',  decrement_string('272690489102840000000000000'));
        $this->assertSame('999999999999999999999999999', decrement_string('1000000000000000000000000000'));
    }
}
