<?php

namespace App\Listeners;

use App\Events\RandomPageGenerated;
use App\Models\BiggestRandomPage;

class RecordBiggestPage
{
    public function handle(RandomPageGenerated $event)
    {
        $currentBiggest = BiggestRandomPage::biggest($event->coin);

        if ($event->pageNumber > $currentBiggest) {
            BiggestRandomPage::create([
                'coin' => $event->coin,
                'page_number' => $event->pageNumber,
            ]);
        }
    }
}
