@extends('layout.base-template', [
    'title'       => 'Cryptocurrency private keys with balance checker',
    'description' => 'SEO description',
])

@section('content')

    <h1>Keys.lol</h1>
    <p class="mb-8">
        All bitcoin, ethereum, litecoin and neo private keys.
        Millions of dollars up for grabs.
    </p>

    <bitcoin-lottery initial-seed="{{ $seed }}"></bitcoin-lottery>

@endsection
