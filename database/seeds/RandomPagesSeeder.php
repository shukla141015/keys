<?php

use App\Events\RandomPageGenerated;
use App\Keys\PageNumbers\BitcoinPageNumber;
use App\Keys\PageNumbers\EthereumPageNumber;
use App\Models\BiggestRandomPage;
use App\Models\SmallestRandomPage;
use App\Support\Enums\CoinType;
use Illuminate\Database\Seeder;

class RandomPagesSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 5000; $i++) {
            if ($i % 100 === 0) {
                $currentSmallestEth = SmallestRandomPage::smallest(CoinType::ETHEREUM);
                $currentSmallestBtc = SmallestRandomPage::smallest(CoinType::BITCOIN);
                $currentBiggestEth = BiggestRandomPage::biggest(CoinType::ETHEREUM);
                $currentBiggestBtc = BiggestRandomPage::biggest(CoinType::BITCOIN);
            }


            $randomBtc = BitcoinPageNumber::random();

            if ($randomBtc->getPageNumber() > $currentBiggestBtc || $randomBtc->getPageNumber() < $currentSmallestBtc) {
                RandomPageGenerated::dispatch($randomBtc);
            }


            $randomEth = EthereumPageNumber::random();

            if ($randomEth->getPageNumber() > $currentBiggestEth || $randomEth->getPageNumber() < $currentSmallestEth) {
                RandomPageGenerated::dispatch($randomEth);
            }
        }
    }
}
