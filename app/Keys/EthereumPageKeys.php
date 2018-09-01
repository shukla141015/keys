<?php

namespace App\Keys;

use App\Keys\PageNumbers\EthereumPageNumber;
use RuntimeException;

class EthereumPageKeys extends PageKeys
{
    protected $pageNumber;

    protected $keys;

    public function __construct(string $pageNumber)
    {
        $btcPageNumber = new EthereumPageNumber($pageNumber);

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
        $output = shell_exec('keys-generator eth '.$this->pageNumber);

        $lines = explode("\n", $output);

        return array_map(function ($line) {
            [$privateKey, $publicKey] = explode(' ', trim($line, '{}'));

            return [
                'privateKey' => $privateKey,
                'publicKey' => $publicKey,
            ];
        }, $lines);
    }
}
