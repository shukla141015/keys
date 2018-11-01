@extends('layout.base-template', [
    'title' => 'Are you human? | Keys.lol',
])

@section('content')

    <div class="mt-16 max-w-xs mx-auto text-center">

        <div class="w-16 mx-auto">
            <img src="/favicon.png" alt="Keys.lol">
        </div>

        <h1 class="my-4">Are you human?</h1>
        <p class="mb-8 leading-normal">
            We don't take kindly to robots around here
        </p>

        <form method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <button class="btn">Yes, i am human</button>
        </form>

    </div>

@endsection
