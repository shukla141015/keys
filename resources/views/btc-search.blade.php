@extends('layout.base-template', [
    'title' => __('seo.title.btc-search'),
    'description' => __('seo.description.btc-search'),
])

@section('content')
    <div class="max-w-md mx-auto">

        <h1 class="my-4">Bitcoin private key search</h1>

        <p class="text-lg leading-normal mb-4">
            This search page will show you the page a specific private key is on.
            <br>
            <br>
            That means if you're curious which page your wallet is on, you can look it up.
            But typing in your own private key on a random website isn't a very good idea.
            <br>
            <br>
            You can only search for wallets that you know the private key of, so you won't have any luck recovering a lost wallet.
            It is impossible to search by public key.
        </p>

        <form enctype="multipart/form-data" method="post" class="flex mb-4">
            {{ csrf_field() }}
            <input type="text" name="private_key" value="{{ old('private_key') }}" class="field py-4 m-0" placeholder="Private key (WIF)" required>

            <button class="btn py-3 ml-2">Search</button>
        </form>

        @if($errors->count())
            <div class="text-red font-bold mb-8">
                Invalid bitcoin wallet import format (WIF)
            </div>
        @endif

        <p class="mb-8 text-xl">
            Instead of searching, you could also try a
            <a class="text-black underline" rel="nofollow" href="{{ route('btcPages.random') }}">random page</a>
        </p>

        @include('components.ads.key-page-bottom')

        <h2>Vanity pages</h2>
        <p class="text-lg leading-normal mb-4">
            You can use this page to look up any wallet you know the private key of.
            Because private keys are basically base58 strings, you can also look up wallets with words in their private key.
            Below are a few examples of interesting pages.
        </p>

        <a class="block" href="{{ route('btcPages', '856083576414584832184365027012002209974486074049742179003044245104477177635') }}">Ominous message in the private keys</a>
        <a class="block" href="{{ route('btcPages', '510237430825191857507550834203449025283598621334783813450916609258406994299') }}">Less ominous message</a>
        <a class="block" href="{{ route('btcPages', '114229580830911906838372329972449433969860788497685910473052341467827083606') }}">1Boat - vanity gen example wallet</a>

    </div>
@endsection
