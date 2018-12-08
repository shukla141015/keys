@extends('layout.base-template', [
    'title' => __('seo.title.eth-index'),
    'description' => __('seo.description.eth-index'),
])

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="my-4">Ethereum keys</h1>

        <p class="text-lg leading-normal mb-4">
            This website contains a sequential database of all Ethereum private keys, spread out on pages of 128 keys each.
            The key to every wallet, including Vitalik Buterin's wallet, are hidden in one of the pages.
            <br>
            <br>
            Ethereum wallets can also contain altcoins. This means you can also find ChainLink, OmiseGO or any of your other favorite altcoins on these pages.
        </p>

        <div class="inline-flex flex-col items-center mb-8" title="Open a random page of Ethereum wallets">
            <a rel="nofollow" href="{{ route('ethPages.random') }}">
                <div class="h-12 w-12">@include('components.svg.ethereum')</div>
            </a>
            <a href="{{ route('ethPages.random') }}" rel="nofollow" class="btn block mt-12">Try your luck</a>
        </div>

        <p class="mb-8 text-lg leading-normal">
            You could also start on the <a class="text-black underline" href="{{ route('ethPages', '1') }}">first page</a> and work your way up.
        </p>

        <h2>Search</h2>
        <p class="leading-normal text-lg mb-8">
            You can find out exactly which page an Ethereum wallet is on by <a class="text-black underline" href="{{ route('ethPages.search') }}">searching</a> for the private key.
        </p>
    </div>
@endsection
