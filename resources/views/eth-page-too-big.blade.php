@extends('layout.base-template', [
    'title'       => 'You have gone too far | Keys.lol',
    'description' => 'There are a lot of ethereum pages, but not THIS many.',
])

@section('content')

    <div class="mt-16 max-w-xs mx-auto text-center">

        <div class="w-16 mx-auto">
            <img src="/favicon.png" alt="Keys.lol">
        </div>

        <h1 class="my-4">You've gone too far</h1>
        <p class="mb-8 leading-normal">
            There aren't THAT many ethereum pages
            <br><br>
            <a class="text-black underline" href="{{ route('ethPages.random') }}">Try a random page instead</a>
        </p>

    </div>

@endsection
