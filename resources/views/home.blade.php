@extends('layout.base-template', [
    'title'       => 'SEO title',
    'description' => 'SEO description',
])

@section('content')

    <bitcoin-lottery initial-seed="{{ $seed }}"></bitcoin-lottery>

@endsection
