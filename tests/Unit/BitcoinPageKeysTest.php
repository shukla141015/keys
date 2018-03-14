<?php

namespace Tests\Unit;

use App\Crypto\BitcoinPageKeys;
use App\Crypto\BitcoinPageNumber;
use Tests\TestCase;

class BitcoinPageKeysTest extends TestCase
{
    /** @test */
    function it_can_generate_keys_for_the_first_page()
    {
        $bitcoinPageKeys = new BitcoinPageKeys('1');

        $this->assertMatchesSnapshot(
            $bitcoinPageKeys->getKeys()
        );
    }

    /** @test */
    function it_can_generate_keys_for_the_last_page()
    {
        $bitcoinPageKeys = new BitcoinPageKeys(
            BitcoinPageNumber::LAST_PAGE_NUMBER
        );

        $this->assertMatchesSnapshot(
            $bitcoinPageKeys->getKeys()
        );
    }

    /** @test */
    function it_can_generate_keys_for_a_random_page()
    {
        $keys = BitcoinPageKeys::generate('374280100293470930');

        $this->assertMatchesSnapshot($keys);
    }

    /** @test */
    function it_retrieves_cached_pages_from_cache()
    {
        $mock = new class (BitcoinPageNumber::LAST_PAGE_NUMBER) extends BitcoinPageKeys{
            protected function retrieveKeysFromCache(): array
            {
                return ['came from cache'];
            }
        };

        $this->assertSame(['came from cache'], $mock->getKeys());
    }
}
