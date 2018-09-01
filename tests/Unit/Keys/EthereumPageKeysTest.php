<?php

namespace Tests\Unit\Keys;

use App\Keys\EthereumPageKeys;
use App\Keys\PageNumbers\BitcoinPageNumber;
use Tests\TestCase;

class EthereumPageKeysTest extends TestCase
{
    /** @test */
    function it_can_generate_keys_for_the_first_page()
    {
        $ethereumPageKeys = new EthereumPageKeys('1');

        $this->assertMatchesSnapshot(
            $ethereumPageKeys->getKeys()
        );
    }

    /** @test */
    function it_can_generate_keys_for_the_last_page()
    {
        $ethereumPageKeys = new EthereumPageKeys(
            BitcoinPageNumber::lastPageNumber()
        );

        $this->assertMatchesSnapshot(
            $ethereumPageKeys->getKeys()
        );
    }

    /** @test */
    function it_can_generate_keys_for_a_random_page()
    {
        $keys = EthereumPageKeys::generate('374280100293470930');

        $this->assertMatchesSnapshot($keys);
    }
}
