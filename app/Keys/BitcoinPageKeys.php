<?php

namespace App\Keys;

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
            $this->keys = $this->isPageCached()
                ? $this->retrieveKeysFromCache()
                : $this->generateKeys();
        }

        return $this->keys;
    }

    protected function isPageCached()
    {
        return file_exists($this->getCacheFilePath());
    }

    protected function getCacheFilePath()
    {
        return app_path('Keys/Cache/BitcoinPages/'.$this->pageNumber.'.php');
    }

    protected function retrieveKeysFromCache(): array
    {
        return include($this->getCacheFilePath());
    }

    protected function generateKeys()
    {
        $output = shell_exec('keys-lol-generator '.$this->pageNumber);

        $lines = array_filter(explode("\n", $output));

        $keys = [];

        foreach ($lines as $line) {
            [$wif, $seed, $pub, $cpub] = explode(' ', $line);

            $keys[] = [
                'wif'  => $wif,
                'pub'  => $pub,
                'cpub' => $cpub,
            ];
        }

        return $keys;
    }

    public static function generate($pageNumber)
    {
        $bitcoinPageKeys = new static($pageNumber);

        return $bitcoinPageKeys->getKeys();
    }
}