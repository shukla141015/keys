<?php

namespace App\Keys;

abstract class PageKeys
{
    abstract public function __construct(string $pageNumber);

    abstract public function getKeys();

    public static function generate($pageNumber)
    {
        $pageKeys = new static($pageNumber);

        return $pageKeys->getKeys();
    }
}
