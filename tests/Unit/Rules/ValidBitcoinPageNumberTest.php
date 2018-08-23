<?php

namespace Tests\Unit\Rules;

use App\Http\Rules\ValidBitcoinPageNumber;
use Tests\TestCase;

class ValidBitcoinPageNumberTest extends TestCase
{
    /** @test */
    function it_fails_on_invalid_page_numbers()
    {
        $this->assertInvalidPageNumber([
            null,
            '0',
            '-1',
            '001',
        ]);
    }

    /** @test */
    function it_rejects_integers()
    {
        $this->assertInvalidPageNumber([
            -1,
            0,
            1,
            100,
        ]);
    }

    /** @test */
    function valid_page_numbers_pass()
    {
        $this->assertValidPageNumber([
            '1',
            '100',
        ]);
    }

    private function assertInvalidPageNumber($number)
    {
        if (is_array($number)) {
            foreach ($number as $value) {
                $this->assertInvalidPageNumber($value);
            }

            return;
        }

        $this->assertFalse(
            (new ValidBitcoinPageNumber)->passes('page', $number)
        );
    }

    private function assertValidPageNumber($number)
    {
        if (is_array($number)) {
            foreach ($number as $value) {
                $this->assertValidPageNumber($value);
            }

            return;
        }

        $this->assertTrue(
            (new ValidBitcoinPageNumber)->passes('page', $number)
        );
    }
}
