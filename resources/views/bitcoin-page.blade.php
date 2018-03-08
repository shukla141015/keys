@extends('layout.base-template', [
    'title'       => 'Bitcoin Private Key Page'.($isShortNumberString ? $pageNumber : ''),
    'description' => 'SEO description',
])

@section('content')

    <h1 class="text-base mb-4">Page {{ $pageNumber }} of {{ config('keys.bitcoin-max-page') }}</h1>


    <div class="flex justify-between mb-4 max-w-md">
        <a href="{{ route('btcPages', 1) }}">first page</a>
        <a href="{{ route('btcPages.random') }}">random page</a>
        <a href="{{ route('btcPages', config('keys.bitcoin-max-page')) }}">last page</a>
    </div>

    <p class="mb-4">
        Every page, except the last one, contains 128 bitcoin private keys.
    </p>

    <bitcoin-page page="{{ $pageNumber }}"></bitcoin-page>

@endsection
