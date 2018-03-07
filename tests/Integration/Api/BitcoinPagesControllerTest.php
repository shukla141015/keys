<?php

namespace Tests\Integration\Api;

use App\Models\BtcPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BitcoinPagesControllerTest extends TestCase
{
    use RefreshDatabase;

    private function putBtcPage(array $data)
    {
        return $this->json('PUT', route('api.btc.page.put'), $data);
    }

    /** @test */
    function it_rejects_invalid_page_numbers()
    {
        $this->putBtcPage([
                'page_number' => '001', // Zero padded numbers are invalid
                'empty'       => true,
            ])
            ->assertStatus(422);

        $this->assertSame(0, BtcPage::all()->count());
    }

    /** @test */
    function it_creates_a_record_for_new_pages()
    {
        $this->putBtcPage([
                'page_number' => '1',
                'empty'       => true,
            ])
            ->assertStatus(200);

        $this->assertSame(1, BtcPage::all()->count());

        $btcPage = BtcPage::findByPageNumber('1');

        $this->assertSame('1', $btcPage->page_number);

        $this->assertTrue($btcPage->empty);
    }

    /** @test */
    function it_updates_existing_records()
    {
        BtcPage::create([
            'page_number' => '123',
            'empty'       => true,
        ]);

        $this->putBtcPage([
            'page_number' => '123',
            'empty'       => false,
        ])->assertStatus(200);

        $this->assertSame(1, BtcPage::all()->count());

        $btcPage = BtcPage::findByPageNumber('123');

        $this->assertFalse($btcPage->empty);
    }

    /** @test */
    function it_updates_the_updated_at_timestamp_even_when_no_data_changes()
    {
        $pageData = [
            'page_number' => '123',
            'empty'       => true,
        ];

        BtcPage::create($pageData);

        $this->progressTime();

        $this->putBtcPage($pageData)->assertStatus(200);

        $btcPage = BtcPage::findByPageNumber('123');

        $this->assertSame('2018-03-07 12:00:00', $btcPage->created_at->toDateTimeString());

        $this->assertSame('2018-03-07 12:01:00', $btcPage->updated_at->toDateTimeString());
    }
}
