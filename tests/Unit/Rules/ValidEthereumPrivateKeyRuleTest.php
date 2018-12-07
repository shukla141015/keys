<?php

namespace Tests\Unit\Rules;

use App\Http\Rules\ValidEthereumPrivateKey;
use Tests\TestCase;

class ValidEthereumPrivateKeyRuleTest extends TestCase
{
    /** @test */
    function it_passes_valid_private_keys()
    {
        $this->assertPasses('00000000000000000000023776b528d65838ea70ab49a65de0a330bd22108389');

        $this->assertPasses('0000000000000000000000000000000000000000000000000000000000000000');

        $this->assertPasses('fffffffffffffffffffffffffffffffebaaedce6af48a03bbfd25e8cd0364154');

        $this->assertPasses('ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff');
    }

    /** @test */
    function it_rejects_invalid_private_keys()
    {
        $this->assertFails('');
        $this->assertFails('virus.exe');
        $this->assertFails('./../../../../../5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4n');
        $this->assertFails('5Km2kuu7vtFDPpxywn4u3NLpbr5jKpTB3jsuDU2KYEqemizF9vA');

        $this->assertFails('00000000000000000000023776b528d65838ea70ab49a65de0a330bd2210838');
        $this->assertFails('00000000000000000000023776b528d65838ea70ab49a65de0a330bd221083899');
    }

    private function assertPasses($pk)
    {
        $this->assertTrue(
            (new ValidEthereumPrivateKey)->passes('abc123', $pk)
        );
    }

    private function assertFails($pk)
    {
        $this->assertFalse(
            (new ValidEthereumPrivateKey)->passes('abc123', $pk)
        );
    }
}
