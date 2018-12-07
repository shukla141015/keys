<?php

namespace Tests\Unit\Keys\Search;

use App\Keys\Search\BitcoinSearch;
use RuntimeException;
use Tests\TestCase;

class BitcoinSearchTest extends TestCase
{
    /** @test */
    function it_can_find_which_page_a_wif_is_on()
    {
        $this->assertBitcoinSearch('1', '5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4nEB3kEsreCw2uZTA');

        $this->assertBitcoinSearch('53453687181290026992639707484692835663121741217363779460769020251266400438', '5Hvwyc8yHKUSFyNbCsEjDquYMCpjeixTBvQqLK41ZJ9nkR8qmza');

        $this->assertBitcoinSearch('904625697166532776746648320380374280100293470930272690489102837043110636675', '5Km2kuu7vtFDPpxywn4u3NLpbr5jKpTB3jsuDU2KYEqemizF9vA');
    }

    /** @test */
    function it_rejects_invalid_wifs()
    {
        $this->assertInvalidSearch('');
        $this->assertInvalidSearch('virus.exe');
        $this->assertInvalidSearch('./../../../../../5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4n');

        $this->assertInvalidSearch('5HpHagT65TZzG1PHHHHu63k8DbpvD8s5ip4nEB3kEsreCw2uZTA');
        $this->assertInvalidSearch('5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4nEB3kEsreCw2uZT');
        $this->assertInvalidSearch('5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4nEB3kEsreCw2uZTAA');
    }

    /** @test */
    function it_throws_an_exception_when_trying_to_get_an_invalid_page_number()
    {
        $btcSearch = new BitcoinSearch('abnsmdasbdm');

        $this->assertFalse(
            $btcSearch->valid()
        );

        $this->expectException(RuntimeException::class);

        $btcSearch->pageNumber();
    }

    private function assertBitcoinSearch($expectedPageNumber, $wif)
    {
        $btcSearch = new BitcoinSearch($wif);

        $this->assertTrue(
            $btcSearch->valid(),
            'Not a valid WIF: '.$wif
        );

        $this->assertSame(
            $expectedPageNumber,
            $btcSearch->pageNumber()
        );
    }

    private function assertInvalidSearch($wif)
    {
        $btcSearch = new BitcoinSearch($wif);

        $this->assertFalse(
            $btcSearch->valid(),
            'Unexpected valid WIF: '.$wif
        );
    }
}
