<?php

namespace App\Keys\Search;

use RuntimeException;

abstract class CoinSearch
{
    protected $pageNumber;

    abstract public function __construct(string $pk);

    public function pageNumber()
    {
        if (! $this->valid()) {
            throw new RuntimeException();
        }

        return $this->pageNumber;
    }

    public function valid()
    {
        return $this->pageNumber !== null;
    }
}
