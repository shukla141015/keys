<?php

namespace App\Keys;

use App\Keys\PageNumbers\BitcoinPageNumber;
use RuntimeException;

class BitcoinPageKeys extends PageKeys
{
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
        $output = shell_exec('keys-generator btc '.$this->pageNumber);

        $lines = explode("\n", $output);

        return array_map(function ($line) {
            [$wif, $cpub, $pub] = explode(' ', trim($line, '{}'));

            return [
                'wif' => $wif,
                'pub' => $pub,
                'cpub' => $cpub,
            ];
        }, $lines);
    }
}
