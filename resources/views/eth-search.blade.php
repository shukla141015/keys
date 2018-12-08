@extends('layout.base-template', [
    'title' => __('seo.title.eth-search'),
    'description' => __('seo.description.eth-search'),
])

@section('content')
    <div class="max-w-md mx-auto">

        <h1 class="my-4">Ethereum private key search</h1>

        <p class="text-lg leading-normal mb-4">
            Reverse search to find out which page an Ethereum wallet is on.
            <br>
            <br>
            You could look up your own wallet, but do you trust a random website that much?
            <br>
            <br>
            If you lost your private key this search won't do you any good.
            Searching for a public key is not possible.
        </p>

        <form enctype="multipart/form-data" method="post" class="flex mb-4">
            {{ csrf_field() }}
            <input type="text" name="private_key" value="{{ old('private_key') }}" class="field py-4 m-0" placeholder="Private key" maxlength="64" title="Ethereum private keys are 64 character, lowercase, hexadecimal strings (0-9, a-f)" pattern="^[0-9a-f]{64}$" required>

            <button class="btn py-3 ml-2">Search</button>
        </form>

        @if($errors->count())
            <div class="text-red font-bold mb-8">
                Invalid Ethereum private key
            </div>
        @endif

        <p class="mb-8 text-xl">
            Instead of searching, you could also try a
            <a class="text-black underline" rel="nofollow" href="{{ route('ethPages.random') }}">random page</a>
        </p>

        @include('components.ads.key-page-bottom')

    </div>
@endsection
