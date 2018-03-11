<?php

namespace App\Crypto;

use BitcoinPHP\BitcoinECDSA\BitcoinECDSA;
use BitWasp\Bitcoin\Key\PrivateKeyFactory;
use RuntimeException;

class BitcoinPageKeys
{
    const KEYS_PER_PAGE = 128;

    /**
     * This is the largest possible seed.
     */
    const LAST_KEY_SEED = '115792089237316195423570985008687907852837564279074904382605163141518161494336';

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
        $keys = [];

        $seed = (string) gmp_mul(decrement_string($this->pageNumber), static::KEYS_PER_PAGE);

        for ($i = 0; $i < static::KEYS_PER_PAGE; $i++) {
            $seed = increment_string($seed);

            $keyPair = PrivateKeyFactory::fromInt($seed);

            $bec = new BitcoinECDSA();

            $wif = $keyPair->toWif();

            $bec->setPrivateKeyWithWif($wif);

            $keys[] = [
                'wif'  => $wif,
                'pub'  => $bec->getUncompressedAddress(),
                'cpub' => $bec->getAddress(),
            ];

            if ($seed === static::LAST_KEY_SEED) {
                break;
            }
        }

        return $keys;
    }

    public static function generate($pageNumber)
    {
        $bitcoinPageKeys = new static($pageNumber);

        return $bitcoinPageKeys->getKeys();
    }
}