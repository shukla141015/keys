<?php

namespace App\Events;

use App\Keys\PageNumbers\PageNumber;

class RandomPageGenerated extends BaseEvent
{
    public $coin;

    public $pageNumber;

    public function __construct(PageNumber $page)
    {
        $this->coin = $page::$coin;

        $this->pageNumber = $page->getPageNumber();
    }
}
