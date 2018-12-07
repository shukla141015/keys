<?php

namespace Tests\Unit\Keys\Search;

use App\Keys\Search\EthereumSearch;
use RuntimeException;
use Tests\TestCase;

class EthereumSearchTest extends TestCase
{
    /** @test */
    function it_can_find_which_page_a_private_key_is_on()
    {
        $this->assertEthereumSearch('904625697166532776746648320380374280100293470930272690489102837043110636675', 'fffffffffffffffffffffffffffffffebaaedce6af48a03bbfd25e8cd0364108');

        $this->assertEthereumSearch('34495810072402145433009645335736827484527960356823588794227465171299925652', '09c3105abe61bd8a805918726d850a1e4a06abb0258da670f5583bfc617f498c');

        $this->assertEthereumSearch('1', '0000000000000000000000000000000000000000000000000000000000000004');
        $this->assertEthereumSearch('1', '0000000000000000000000000000000000000000000000000000000000000000');
    }

    /** @test */
    function it_rejects_invalid_private_keys()
    {
        $this->assertInvalidSearch('');
        $this->assertInvalidSearch('virus.exe');
        $this->assertInvalidSearch('./../../../../../5HpHagT65TZzG1PH3CSu63k8DbpvD8s5ip4n');

        $this->assertInvalidSearch('3449581007240214543300964533573682748452796035682358879422746517129992565');
        $this->assertInvalidSearch('344958100724021454330096453357368274845279603568235887942274651712999256522');
    }

    /** @test */
    function it_throws_an_exception_when_trying_to_get_an_invalid_page_number()
    {
        $btcSearch = new EthereumSearch('abnsmdasbdm');

        $this->assertFalse(
            $btcSearch->valid()
        );

        $this->expectException(RuntimeException::class);

        $btcSearch->pageNumber();
    }

    private function assertEthereumSearch($expectedPageNumber, $pk)
    {
        $btcSearch = new EthereumSearch($pk);

        $this->assertTrue(
            $btcSearch->valid(),
            'Not a valid private key: '.$pk
        );

        $this->assertSame(
            $expectedPageNumber,
            $btcSearch->pageNumber()
        );
    }

    private function assertInvalidSearch($pk)
    {
        $btcSearch = new EthereumSearch($pk);

        $this->assertFalse(
            $btcSearch->valid(),
            'Unexpected valid private key: '.$pk
        );
    }
}
