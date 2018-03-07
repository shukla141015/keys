<?php

namespace App\Crypto;

class BitcoinPageNumber
{
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

        // TODO: check if number is too big (> 256 bit)

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

    public function isSmallNumber()
    {
        return $this->isShortNumberString() && (int) $this->pageNumber <= 10;
    }
}