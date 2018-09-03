@extends('layout.base-template', [
    'title'       => __('seo.title.home'),
    'description' => __('seo.description.home'),
    'keywords'    => __('seo.keywords.home'),
])

@section('content')

    <div class="max-w-md mx-auto">

        <h1 class="my-4 max-w-md">
            Every Bitcoin and Ethereum private key is on this website
        </h1>

        <p class="mb-8 leading-normal">
            <span class="text-xl">Yes, your private keys are somewhere on here too</span>
            <br>
            <br>
            For most cryptocurrencies, there are (only) 2^256 different private keys.
            The chance of finding a used wallet is small, but it is not impossible.
            If you have enough time, you can find the private key to any wallet you want, and of course, finders keepers
            <br>
            <br>
            Page numbers are used to generate private keys.
            Every page, except the last one, contains 128 addresses.
            The first wallet of the first page is generated using the seed "1", the second wallet of the first page with the seed "2", and so on.
            The last wallet on the last page is generated using the largest possible wallet seed.
            The keys are procedurally generated on the fly every time a page is opened.
            <br><br>
            The balance of each wallet is automatically checked.
            Wallets with a balance are colored green.
            Wallets that have never been used are red.
            Bitcoin wallets that have been used in the past but are now empty will turn yellow.
        </p>

        <p class="mb-8 text-xl">
            Try your luck with
            <a class="text-black underline" rel="nofollow" href="{{ route('btcPages.random') }}">random Bitcoin keys</a>
            or
            <a class="text-black underline" rel="nofollow" href="{{ route('ethPages.random') }}">random Ethereum keys</a>
        </p>

    </div>

@endsection
