<?php

namespace App\Keys;

class BitcoinPageNumber
{
    const LAST_PAGE_NUMBER = '904625697166532776746648320380374280100293470930272690489102837043110636675';

    protected $redirectTo;

    protected $pageNumber;

    public function __construct($pageNumber)
    {
        // 256 bit numbers don't fit in a php integer. Page numbers should always be strings.
        $this->pageNumber = is_string($pageNumber) ? $pageNumber : null;

        $this->redirectTo = $this->validatePageNumber($pageNumber);
    }

    protected function validatePageNumber($pageNumber)
    {
        if ($pageNumber === null) {
            return redirect()->route('btcPages', 1);
        }

        if (! preg_match('/^\d+$/', $pageNumber)) {
            return redirect()->route('btcPages', 1);
        }

        $actualNumber = ltrim($pageNumber, '0');

        // Redirect if the "pageNumber" was all zeroes
        if ($actualNumber === '') {
            return redirect()->route('btcPages', 1);
        }

        // Redirect zero padded page numbers to non-padded page numbers.
        if ($actualNumber !== $pageNumber) {
            return redirect()->route('btcPages', $actualNumber);
        }

        // TODO: redirect numbers that are too large to a special error page.
        if ($this->pageNumberExceedsMaxPageNumber($pageNumber)) {
            return redirect()->route('btcPages', 1);
        }

        return null;
    }

    protected function pageNumberExceedsMaxPageNumber($pageNumber)
    {
        if (strlen($pageNumber) > strlen(static::LAST_PAGE_NUMBER)) {
            return true;
        }

        if (strlen($pageNumber) !== strlen(static::LAST_PAGE_NUMBER)) {
            return false;
        }

        for ($i = 0; $i < strlen($pageNumber); $i++) {
            $pageInt = (int) $pageNumber[$i];
            $maxInt = (int) static::LAST_PAGE_NUMBER[$i];

            if ($pageInt === $maxInt) {
                continue;
            }

            if ($pageInt < $maxInt) {
                return false;
            }

            if ($pageInt > $maxInt) {
                return true;
            }
        }

        // All numbers are the same, "pageNumber" is the last page.
        return false;
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

    public function isSmallNumber()
    {
        return $this->isShortNumberString() && (int) $this->pageNumber <= 10;
    }

    public static function random(): string
    {
        do {
            $randomPageNumber = '';

            for ($i = 0; $i < strlen(static::LAST_PAGE_NUMBER); $i++) {
                $randomPageNumber .= rand(0, 9);
            }

            // Validate the number to make sure it isn't larger than
            // the last page number, or consists only of zeros.
            $btcPage = new static(ltrim($randomPageNumber, '0'));
        } while (! $btcPage->isValid());

        return ltrim($randomPageNumber, '0');
    }
}