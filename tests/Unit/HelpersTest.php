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

    /** @test */
    function it_adds_strings()
    {
        $this->assertStringSum('120', '60', '60');
        $this->assertStringSum('120', '119', '1');
        $this->assertStringSum('100', '99', '1');
        $this->assertStringSum('10', '9', '1');
        $this->assertStringSum('18', '9', '9');
        $this->assertStringSum('2', '1', '1');
        $this->assertStringSum('1', '0', '1');
        $this->assertStringSum('0', '0', '0');
        $this->assertStringSum('2468', '1234', '1234');

        $this->assertStringSum(
            '870716688342364853975365894154599769712962143345333225431389660050866979673',
            '313015305269185423628099159834069627536526592993287756940460710784696594757',
            '557701383073179430347266734320530142176435550352045468490928949266170384916'
        );

        $this->assertStringSum(
            '668388534299691177188542390569847376587338171248254852185003778511939187024',
            '568555098059380248670874398181727985519233484839085254945240676216548165251',
            '99833436240310928517667992388119391068104686409169597239763102295391021773'
        );
    }

    /** @test */
    function it_subtracts_strings()
    {
        $this->assertSubtractString('60', '120', '60');
        $this->assertSubtractString('119', '120', '1');
        $this->assertSubtractString('99', '100', '1');
        $this->assertSubtractString('9', '10', '1');
        $this->assertSubtractString('9', '18', '9');
        $this->assertSubtractString('1', '2', '1');
        $this->assertSubtractString('0', '1', '1');
        $this->assertSubtractString('0', '0', '0');
        $this->assertSubtractString('1234', '2468', '1234');

        $this->assertSubtractString(
            '313015305269185423628099159834069627536526592993287756940460710784696594757',
            '870716688342364853975365894154599769712962143345333225431389660050866979673',
            '557701383073179430347266734320530142176435550352045468490928949266170384916'
        );

        $this->assertSubtractString(
            '568555098059380248670874398181727985519233484839085254945240676216548165251',
            '668388534299691177188542390569847376587338171248254852185003778511939187024',
            '99833436240310928517667992388119391068104686409169597239763102295391021773'
        );
    }

    /** @test */
    function it_formats_string_numbers()
    {
        $this->assertSame(number_format('1'), string_number_format('1'));
        $this->assertSame(number_format('10'), string_number_format('10'));
        $this->assertSame(number_format('100'), string_number_format('100'));
        $this->assertSame(number_format('1000'), string_number_format('1000'));
        $this->assertSame(number_format('10000'), string_number_format('10000'));
        $this->assertSame(number_format('100000'), string_number_format('100000'));
        $this->assertSame(number_format('1000000'), string_number_format('1000000'));
        $this->assertSame(number_format('10000000'), string_number_format('10000000'));
        $this->assertSame(number_format('100000000'), string_number_format('100000000'));
        $this->assertSame(number_format('1000000000'), string_number_format('1000000000'));
        $this->assertSame(number_format('10000000000'), string_number_format('10000000000'));
        $this->assertSame(number_format('100000000000'), string_number_format('100000000000'));
        $this->assertSame('1,000,000,000,000,000,000,000,000,000,000', string_number_format('1000000000000000000000000000000'));
    }

    /** @test */
    function print_biggest_page_number_test()
    {
        $this->assertSame(
            '<strong>9046256</strong>53129020688240428395762821224102696154718365249879361653537858602398',
            print_biggest_page_number(
                '904625653129020688240428395762821224102696154718365249879361653537858602398',
                '904625697166532776746648320380374280100293470930272690489102837043110636675'
            )
        );

        $this->assertSame(
            '<strong>904625</strong>553129020688240428395762821224102696154718365249879361653537858602398',
            print_biggest_page_number(
                '904625553129020688240428395762821224102696154718365249879361653537858602398',
                '904625697166532776746648320380374280100293470930272690489102837043110636675'
            )
        );

        $this->assertSame(
            '190031471139778730205922845677707689160635114547012625251267873851689118756',
            print_biggest_page_number(
                '190031471139778730205922845677707689160635114547012625251267873851689118756',
                '904625697166532776746648320380374280100293470930272690489102837043110636675'
            )
        );

        $this->assertSame(
        // 1 digit short
            '070940976163445420973029362395039830264000949798951519500851346323166575469',
            print_biggest_page_number(
                '70940976163445420973029362395039830264000949798951519500851346323166575469',
                '904625697166532776746648320380374280100293470930272690489102837043110636675'
            )
        );
    }

    /** @test */
    function print_smallest_page_number_test()
    {
        $this->assertSame(
            '190031471139778730205922845677707689160635114547012625251267873851689118756',
            print_smallest_page_number(
                '190031471139778730205922845677707689160635114547012625251267873851689118756',
                '904625697166532776746648320380374280100293470930272690489102837043110636675'
            )
        );

        $this->assertSame(
            '<strong>000000</strong>579520216238304854969540795109008812499428264122713103185892087806348',
            print_smallest_page_number(
                '579520216238304854969540795109008812499428264122713103185892087806348',
                '904625697166532776746648320380374280100293470930272690489102837043110636675'
            )
        );
    }

    private function assertStringSum($expected, $a, $b)
    {
        $this->assertSame(
            $expected,
            $actual = string_add($a, $b),
            "Expecting $a + $b = $expected, actual was $actual"
        );
    }

    private function assertSubtractString($expected, $a, $b)
    {
        $this->assertSame(
            $expected,
            $actual = string_subtract($a, $b),
            "Expecting $a - $b = $expected, actual was $actual"
        );
    }
}
