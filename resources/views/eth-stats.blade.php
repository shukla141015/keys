@extends('layout.base-template', [
    'title'       => __('seo.title.eth-stats'),
    'description' => __('seo.description.eth-stats'),
])

@section('content')

    <div class="max-w-lg mx-auto">

        <h1 class="mt-4">Ethereum statistics</h1>

        <p class="text-lg leading-normal mb-4">
            Statistics have been collected since the first of September, 2018.
            <br>
            Dates are in server time (Europe/Asmterdam).
            <br><br>
            Also take a look at the <a class="text-black underline" rel="nofollow" href="{{ route('stats') }}">global statistics</a>.
        </p>

        <h2>Ethereum keys generated</h2>
        <p class="text-lg leading-normal mb-4">
            Every time an ethereum page is visited, keys are generated.
            Below are the total amount of ethereum private keys that have been generated.
            <br>
            <br>

            @include('components.stats.keys-generated')
        </p>

        <h2>Smallest random page</h2>
        <p class="text-lg leading-normal mb-4">
            The list below shows the smallest page number that has been generated for random ethereum pages.
        </p>

        @include('components.stats.smallest-random-page', ['hideCoin' => true])

        <h2>Biggest random page</h2>
        <p class="text-lg leading-normal mb-4">
            The list below shows the biggest page number that has been generated for random ethereum pages.
        </p>

        @include('components.stats.biggest-random-page', ['hideCoin' => true])

    </div>

@endsection
