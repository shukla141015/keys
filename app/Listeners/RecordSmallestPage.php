<?php

namespace App\Listeners;

use App\Events\RandomPageGenerated;
use App\Models\SmallestRandomPage;

class RecordSmallestPage
{
    public function handle(RandomPageGenerated $event)
    {
        if (! $this->shouldCompareWithDatabase($event)) {
            return;
        }

        $currentSmallest = SmallestRandomPage::smallest($event->coin);

        if ($event->pageNumber < $currentSmallest) {
            SmallestRandomPage::create([
                'coin' => $event->coin,
                'page_number' => $event->pageNumber,
            ]);
        }
    }

    private function shouldCompareWithDatabase($event)
    {
        if (! config('keys.enable_page_number_hardcoded_check')) {
            return true;
        }

        return starts_with($event->pageNumber, '00000');
    }
}
