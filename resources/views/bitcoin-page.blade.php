@extends('layout.base-template', [
    'title'       => 'Bitcoin Private Key Page'.($isShortNumberString ? $pageNumber : ''),
    'description' => 'SEO description',
])

@section('content')

    <bitcoin-page
            page="{{ $pageNumber }}"
            last-seen="{{ $lastSeen }}"
            :was-empty="{{ $wasEmpty ? 1 : 0 }}"
    ></bitcoin-page>

@endsection
