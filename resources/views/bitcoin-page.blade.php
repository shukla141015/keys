@extends('layout.base-template', [
    'title'       => 'Bitcoin Private Key Page'.($isShortNumberString ? $pageNumber : ''),
    'description' => 'SEO description',
])

@section('content')

    <bitcoin-page page="{{ $pageNumber }}"></bitcoin-page>

@endsection
