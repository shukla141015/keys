<?php

namespace Tests\Unit\Rules;

use App\Http\Rules\ValidBitcoinWif;
use Tests\TestCase;

class ValidBitcoinWifRuleTest extends TestCase
{
    /** @test */
    function it_passes_valid_wifs()
    {
        $this->assertPasses('5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4nEB3kEsreCw2uZTA');

        $this->assertPasses('5Hvwyc8yHKUSFyNbCsEjDquYMCpjeixTBvQqLK41ZJ9nkR8qmza');

        $this->assertPasses('5Km2kuu7vtFDPpxywn4u3NLpbr5jKpTB3jsuDU2KYEqemizF9vA');
    }

    /** @test */
    function it_rejects_invalid_wifs()
    {
        $this->assertFails('');
        $this->assertFails('virus.exe');
        $this->assertFails('./../../../../../5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4n');
        $this->assertFails('\'5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4nEB3kEsreCw2uZTA\'');
    }

    private function assertPasses($wif)
    {
        $this->assertTrue(
            (new ValidBitcoinWif)->passes(str_random(), $wif)
        );
    }

    private function assertFails($wif)
    {
        $this->assertFalse(
            (new ValidBitcoinWif)->passes(str_random(), $wif)
        );
    }
}
