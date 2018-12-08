@extends('layout.base-template', [
    'title' => __('seo.title.btc-index'),
    'description' => __('seo.description.btc-index'),
])

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="my-4">Bitcoin keys</h1>

        <p class="text-lg leading-normal mb-8">
            This website contains a sequential database of all Bitcoin private keys, spread out on pages of 128 keys each.
            The key to every bitcoin wallet, including Satoshi Nakamoto's wallet, is hidden in one of the pages.
        </p>

        <div class="inline-flex flex-col items-center mb-8" title="Open a random page of Bitcoin wallets">
            <a rel="nofollow" href="{{ route('btcPages.random') }}">
                <div class="h-16 w-16">@include('components.svg.bitcoin')</div>
            </a>
            <a href="{{ route('btcPages.random') }}" rel="nofollow" class="btn block mt-4">Try your luck</a>
        </div>

        <p class="mb-8 text-lg leading-normal">
            You could also start on the <a class="text-black underline" href="{{ route('btcPages', '1') }}">first page</a> and work your way up.
        </p>

        <h2>Search</h2>
        <p class="leading-normal text-lg mb-8">
            You can find out exactly which page a Bitcoin wallet is on by <a class="text-black underline" href="{{ route('btcPages.search') }}">searching</a> for the private key.
        </p>
    </div>
@endsection
