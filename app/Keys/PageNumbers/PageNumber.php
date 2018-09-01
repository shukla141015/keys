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

    protected function validatePageNumber($pageNumber): ?RedirectResponse
    {
        if ($pageNumber === null) {
            return redirect()->route(static::$coin.'Pages', 1);
        }

        if (! preg_match('/^\d+$/', $pageNumber)) {
            return redirect()->route(static::$coin.'Pages', 1);
        }

        $actualNumber = ltrim($pageNumber, '0');

        // Redirect if the "pageNumber" was all zeroes
        if ($actualNumber === '') {
            return redirect()->route(static::$coin.'Pages', 1);
        }

        // Redirect zero padded page numbers to non-padded page numbers.
        if ($actualNumber !== $pageNumber) {
            return redirect()->route(static::$coin.'Pages', $actualNumber);
        }

        if ($pageNumber > static::lastPageNumber()) {
            return redirect()->route(static::$coin.'Pages.pageTooBig');
        }

        return null;
    }

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
