<?php

namespace App\Listeners;

use App\Events\RandomPageGenerated;
use App\Models\SmallestRandomPage;

class RecordSmallestPage
{
    public function handle(RandomPageGenerated $event)
    {
        $currentSmallest = SmallestRandomPage::smallest($event->coin);

        if ($event->pageNumber < $currentSmallest) {
            SmallestRandomPage::create([
                'coin' => $event->coin,
                'page_number' => $event->pageNumber,
            ]);
        }
    }
}
