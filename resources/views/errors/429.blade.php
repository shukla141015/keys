@extends('layout.base-template', [
    'title' => 'Too many requests | Keys.lol',
])

@section('content')

    <div class="mt-16 max-w-xs mx-auto text-center">

        <div class="w-16 mx-auto">
            <img src="/favicon.png" alt="Keys.lol">
        </div>

        <h1 class="my-4">Too many requests</h1>
        <p class="mb-8 leading-normal">
            You are looking up a lot of keys, if keep this up you'll literally crash bitcoin
            <br><br>
            You can look up more keys in a minute
        </p>

    </div>

@endsection
