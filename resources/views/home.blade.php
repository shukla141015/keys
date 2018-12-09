@extends('layout.base-template', [
    'title' => __('seo.title.home'),
    'description' => __('seo.description.home'),
    'keywords' => __('seo.keywords.home'),
])

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="my-4">Every Bitcoin and Ethereum private key is on this website</h1>

        <p>
            Yes, your private key is on this website too, but don't worry, nobody will ever find it.
            <br>
            <br>
            If you want to try finding your wallet, click one of the buttons below.
        </p>

        <div class="flex items-center justify-between sm:justify-start my-8">
            <div class="flex flex-col items-center mr-0 sm:mr-32" title="Open a random page of Bitcoin wallets">
                <a rel="nofollow" href="{{ route('btcPages.random') }}">
                    <div class="h-16 w-16">@include('components.svg.bitcoin')</div>
                </a>
                <a href="{{ route('btcPages.random') }}" rel="nofollow" class="btn block mt-4">Random page</a>
            </div>

            <div class="flex flex-col items-center" title="Open a random page of Ethereum wallets">
                <a rel="nofollow" href="{{ route('ethPages.random') }}">
                    <div class="h-12 w-12 -mt-4">@include('components.svg.ethereum')</div>
                </a>
                <a href="{{ route('ethPages.random') }}" rel="nofollow" class="btn block mt-12">Random page</a>
            </div>
        </div>

        <h2 class="mb-2">How does this work?</h2>
        <p class="leading-normal">
            A private key is basically just a number between 1 and 2<sup>256</sup>.
            This website generates keys for all of those numbers, spread out over pages of 128 keys each.
            <br>
            <br>
            This website doesn't actually have a database of all private keys, that would take an impossible amount of disk space.
            Instead, keys are procedurally generated on the fly when a page is opened.
            The page number is used to calculate which keys should be on that page.
            <br>
            <br>
            Finding an active wallet is hard, but not impossible.
            Every time you open a random page, you have a chance of finding someone else's fortune.
            <br>
            <br>
            If you're curious which page your wallet is on, you could do a <a class="underline" href="{{ route('btcPages.search') }}">search</a> for it.
            That will show you exactly which page your wallet is on.
        </p>

        <h2 class="mt-8 mb-2">Automatic balance checking</h2>
        <p class="leading-normal">
            The balance of each wallet is automatically checked.
            Wallets with a balance are colored green.
            Wallets that have been used in the past but are now empty will turn yellow.
            Wallets that have never been used are red.
        </p>

        <div class="mb-8"></div>
    </div>
@endsection
