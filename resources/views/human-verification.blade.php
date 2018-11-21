@extends('layout.base-template', [
    'title' => 'Are you human? | Keys.lol',
])

@push('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush

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

            <div class="inline-block mx-auto">
                <div class="g-recaptcha" data-sitekey="{{ config('keys.recaptcha_site_key') }}"></div>
            </div>

            <button class="btn mt-8">Yes, i am human</button>
        </form>

    </div>

@endsection
