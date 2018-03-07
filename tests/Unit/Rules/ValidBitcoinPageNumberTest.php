<?php

namespace Tests\Unit\Rules;

use App\Http\Rules\ValidBitcoinPageNumber;
use Tests\TestCase;

class ValidBitcoinPageNumberTest extends TestCase
{
    /** @test */
    function it_fails_on_invalid_page_numbers()
    {
        $this->assertFalse(
            // "null" is never a valid page number.
            (new ValidBitcoinPageNumber)->passes('page', null)
        );

        $this->assertFalse(
            // Negative numbers are invalid.
            (new ValidBitcoinPageNumber)->passes('page', '-1')
        );

        $this->assertFalse(
            // Zero padded numbers are invalid.
            (new ValidBitcoinPageNumber)->passes('page', '001')
        );
    }

    /** @test */
    function it_rejects_integers()
    {
        $this->assertFalse(
            (new ValidBitcoinPageNumber)->passes('page', 100)
        );
    }

    /** @test */
    function valid_page_numbers_pass()
    {
        $this->assertTrue(
            (new ValidBitcoinPageNumber)->passes('page', '100')
        );
    }
}
