<?php

namespace App\Keys\PageNumbers;

use Illuminate\Http\RedirectResponse;

abstract class PageNumber
{
    public static $coin = null;

    protected $redirectTo;

    protected $pageNumber;

    public function __construct($pageNumber)
    {
        // 256 bit numbers don't fit in a php integer. Page numbers should always be strings.
        $this->pageNumber = is_string($pageNumber) ? $pageNumber : null;

        $this->redirectTo = $this->validatePageNumber($pageNumber);
    }

    abstract protected function validatePageNumber($pageNumber): ?RedirectResponse;

    public function shouldRedirect()
    {
        return $this->redirectTo !== null;
    }

    public function isValid()
    {
        return ! $this->shouldRedirect();
    }

    public function redirect()
    {
        return $this->redirectTo;
    }

    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    public function isShortNumberString()
    {
        return strlen($this->pageNumber) <= 10;
    }

    public static function lastPageNumber()
    {
        static $lastPageNumber = null;

        if ($lastPageNumber === null) {
            $lastPageNumber = config('keys.'.static::$coin.'.max_page');
        }

        return $lastPageNumber;
    }

    public static function random(): PageNumber
    {
        $maxPageLength = strlen(static::lastPageNumber());

        do {
            $randomPageNumber = '';

            for ($i = 0; $i < $maxPageLength; $i++) {
                $randomPageNumber .= rand(0, 9);
            }

            // Validate the number to make sure it isn't larger than
            // the last page number, or consists only of zeros.
            $pageNumber = new static(ltrim($randomPageNumber, '0'));
        } while (! $pageNumber->isValid());

        return $pageNumber;
    }
}
