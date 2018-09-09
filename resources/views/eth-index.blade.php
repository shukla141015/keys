@extends('layout.base-template', [
    'title'       => __('seo.title.eth-index'),
    'description' => __('seo.description.eth-index'),
])

@section('content')

    <div class="max-w-md mx-auto">

        <h1 class="my-4">Ethereum keys</h1>

        <p class="text-lg leading-normal mb-4">
            This website contains a sequential database of all 2^256 ethereum private keys, spread out on pages of 128 keys each.
            The key to every wallet, including Vitalik Buterin's wallet, are hidden in one of the pages.
        </p>

        <p class="mb-8 text-lg">
            Ethereum keys generated today: <span class="text-2xl font-bold">{{ number_format($keysToday) }}</span>
        </p>

        <p class="mb-8 text-lg">
            Also take a look at more <a class="text-black underline" href="{{ route('ethPages.stats') }}">ethereum page statistics</a>.
        </p>

        <p class="mb-8 text-lg leading-normal">
            Ethereum wallets can also contain altcoins. This means you can also find ChainLink, OmiseGO or any of your other favorite altcoins on these pages.
        </p>

        <p class="mb-8 text-lg leading-normal">
            Some people say you're better off buying a lottery ticket, but what do they know? You might hit it big on your first random page.
        </p>

        <p class="mb-8 text-xl">
            Get started on
            <a class="text-black underline" rel="nofollow" href="{{ route('ethPages', 1) }}">page one</a>
            or try a
            <a class="text-black underline" rel="nofollow" href="{{ route('ethPages.random') }}">random page</a>
        </p>

    </div>

@endsection
