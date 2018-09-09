@extends('layout.base-template', [
    'title'       => 'Statistics | Keys.lol',
    'description' => 'Global statistics for keys.lol. Shows the total amount of keys generated, and the smallest/biggest random pages generated.',
])

@section('content')

    <div class="max-w-lg mx-auto">

        <h1 class="mt-4">Statistics</h1>

        <p class="text-lg leading-normal mb-4">
            Statistics have been collected since the first of September, 2018.
            <br>
            Dates are in server time (Europe/Asmterdam).
            <br><br>
            Also take a look at the coin specific statistics:
            <a class="text-black underline" rel="nofollow" href="{{ route('btcPages.stats') }}">bitcoin</a>,
            <a class="text-black underline" rel="nofollow" href="{{ route('ethPages.stats') }}">ethereum</a>.
        </p>

        <h2>Keys generated</h2>
        <p class="text-lg leading-normal mb-4">
            Every time a page is visited, keys are generated.
            Below are the total amount of private keys that have been generated.
            <br>
            <br>

            @include('components.stats.keys-generated')
        </p>

        <h2>Smallest random page</h2>
        <p class="text-lg leading-normal mb-4">
            The list below shows the smallest page number that has been generated for random pages.
        </p>

        @include('components.stats.smallest-random-page', ['hideCoin' => false])

        <h2>Biggest random page</h2>
        <p class="text-lg leading-normal mb-4">
            The list below shows the biggest page number that has been generated for random pages.
        </p>

        @include('components.stats.biggest-random-page', ['hideCoin' => false])

    </div>

@endsection
