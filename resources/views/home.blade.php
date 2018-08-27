@extends('layout.base-template', [
    'title'       => 'Keys.lol | All cryptocurrency private keys with balance checker',
    'description' => 'All bitcoin and ethereum private keys. Pages have wallets generated from page numbers with automatic balance checker.',
])

@section('content')

    <div class="max-w-md mx-auto">

        <h1 class="my-4 max-w-sm">
            Every Bitcoin private key is on this website
        </h1>

        <p class="mb-8 leading-normal">
            <span class="text-xl">Yes, your private key is somewhere on here too</span>
            <br>
            <br>
            There are (only) 2^160 possible bitcoin addresses, and they are all on this website.
            If you have enough time, you can find the private key to any wallet you want, and of course, finders keepers
            <br>
            <br>
            Page numbers are used to generate private keys <a class="text-black italic" href="https://en.bitcoin.it/wiki/Wallet_import_format" rel="nofollow" target="_blank">(wallet import formats)</a>.
            Every page, except the last one, contains 128 keys.
            The first wallet of the first page is generated using the seed "1", the second wallet with the seed "2", and so on.
            The last wallet on the last page is generated using the largest possible bitcoin wallet seed.
            The keys are procedurally generated on the fly every time a page is opened.
            <br><br>
            The balance of each wallet is automatically checked using the <a class="italic" href="https://www.blockchain.com/" rel="nofollow" target="_blank">Blockchain.com</a> api.
            Wallets with a balance are colored green.
            Wallets that have been used in the past but are now empty will turn yellow.
            Wallets that have never been used are red.
        </p>

        <p class="mb-8 text-xl">
            Try your luck with a <a class="text-black underline" href="{{ route('btcPages.random') }}">page of random Bitcoin private keys</a>
        </p>

    </div>

@endsection
