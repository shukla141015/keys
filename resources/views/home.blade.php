@extends('layout.base-template', [
    'title'       => 'Cryptocurrency private keys with balance checker',
    'description' => 'SEO description',
])

@section('content')

    <bitcoin-lottery initial-seed="{{ $seed }}"></bitcoin-lottery>

@endsection
