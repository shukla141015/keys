<?php

namespace App\Keys;

use App\Keys\PageNumbers\BitcoinPageNumber;
use RuntimeException;

class BitcoinPageKeys
{
    const KEYS_PER_PAGE = 128;

    protected $pageNumber;

    protected $keys;

    public function __construct(string $pageNumber)
    {
        $btcPageNumber = new BitcoinPageNumber($pageNumber);

        if (! $btcPageNumber->isValid()) {
            throw new RuntimeException('Invalid page number');
        }

        $this->pageNumber = $pageNumber;
    }

    public function getKeys()
    {
        if ($this->keys === null) {
            $this->keys = $this->generateKeys();
        }

        return $this->keys;
    }

    protected function generateKeys()
    {
        $output = shell_exec('keys-lol-generator '.$this->pageNumber);

        $lines = array_filter(explode("\n", $output));

        return array_map(function ($line) {
            [$wif, $seed, $pub, $cpub] = explode(' ', $line);

            return [
                'wif'  => $wif,
                'pub'  => $pub,
                'cpub' => $cpub,
            ];
        }, $lines);
    }

    public static function generate($pageNumber)
    {
        $bitcoinPageKeys = new static($pageNumber);

        return $bitcoinPageKeys->getKeys();
    }
}