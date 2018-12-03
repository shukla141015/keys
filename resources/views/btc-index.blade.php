@extends('layout.base-template', [
    'title'       => __('seo.title.btc-index'),
    'description' => __('seo.description.btc-index'),
])

@section('content')

    <div class="max-w-md mx-auto">

        <h1 class="my-4">Bitcoin keys</h1>

        <p class="text-lg leading-normal mb-4">
            This website contains a sequential database of all 2^256 bitcoin private keys, spread out on pages of 128 keys each.
            The key to every bitcoin wallet, including Satoshi Nakamoto's wallet, is hidden in one of the pages.
        </p>

        <p class="mb-8 text-lg">
            Bitcoin keys generated today: <span class="text-2xl font-bold">{{ number_format($keysToday) }}</span>
        </p>

        <p class="mb-8 text-lg">
            Also take a look at more <a class="text-black underline" href="{{ route('btcPages.stats') }}">bitcoin page statistics</a>.
        </p>

        <p class="mb-8 text-lg leading-normal">
            The odds of finding an active wallet aren't big, but who knows, you might get lucky.
            Any random page could contain a fortune.

        </p>

        <p class="mb-8 text-xl">
            Get started on
            <a class="text-black underline" rel="nofollow" href="{{ route('btcPages', 1) }}">page one</a>
            or try a
            <a class="text-black underline" rel="nofollow" href="{{ route('btcPages.random') }}">random page</a>
        </p>


        <a class="text-black underline" rel="nofollow" href="{{ route('btcPages.search') }}">search</a>

    </div>

@endsection
