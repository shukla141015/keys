@extends('layout.base-template', [
    'title'       => 'All Bitcoin Private Keys'.($isShortNumberString ? ' - Page '.$pageNumber : ''),
    'description' => '128 bitcoin private keys with automatic balance checker. Find a fortune on these pages filled with all bitcoin private keys.',
])

@if(! $isOnFirstPage && ! $isOnLastPage)
    @push('head')
        <meta name="robots" content="noindex">
    @endpush
@endif

@section('content')

    <div class="max-w-md mx-auto">
        <h1 class="flex flex-col text-base break-words text-center">
            <span>Bitcoin page</span>
            <span class="text-sm my-1">{{ $pageNumber }}</span>
            <span>of</span>
            <span class="text-sm my-1">{{ $lastPage }}</span>
        </h1>

        @include('components.bitcoin-page-pagination')
    </div>


    <p class="mb-4 max-w-md mx-auto">
        @if ($isOnFirstPage)
            This is the first page of bitcoin private keys.
            There are 128 wallets on this page.
            Wallets are seeded based on page number, this page contains wallets with seeds from 1 to 128.

            Every bitcoin private key is on this website.
        @elseif($isOnLastPage)
            This is the last page, this page only has 64 wallets on it.
        @endif
    </p>

    <div class="max-w-2xl mx-auto">
    @foreach($keys as $key)
        <div id="{{ $key['wif'] }}" data-loaded="0" class="wallet loading flex flex-col lg:flex-row font-mono text-sm pl-2 lg:py-0 py-2">

            <span class="mr-4 inline-block" style="min-width: {{ $isOnFirstPage ? '108px' : ($isOnLastPage || $pageNumber === '3' ? '100px' : '') }}">
                <strong data-balance="0" class="wallet-balance">0 btc</strong>
                <span data-tx="0" class="wallet-tx">(? tx)</span>
            </span>

            <span class="lg:mr-4 text-xs sm:text-sm break-words">{{ $key['wif'] }}</span>

            <div class="lg:block flex">
                <span class="mr-8 lg:mr-4">
                    <a href="https://blockchain.info/address/{{ $key['pub'] }}" rel="nofollow" target="_blank">
                        <span class="hidden xl:inline-block">{!! str_repeat('&nbsp;', 34 - strlen($key['pub'])) !!}{{ $key['pub'] }}</span>                           {{-- TODO: NEEDS EXTRA PADDING!! --}}
                        <span class="xl:hidden inline-block">public key</span>
                    </a>
                </span>
                <span>
                    <a href="https://blockchain.info/address/{{ $key['cpub'] }}" rel="nofollow" target="_blank">
                        <span class="hidden xl:inline-block">{{ $key['cpub'] }}</span>
                        <span class="xl:hidden inline-block">compressed public key</span>
                    </a>
                </span>
            </div>

        </div>
    @endforeach
    </div>

    <div>
        @include('components.bitcoin-page-pagination', ['includeFirstAndLast' => false])
    </div>

@endsection

@push('footer')
    <script>
        const keys = @json($keys);
        const isOnFirstPage = @json($isOnFirstPage);
        const isOnLastPage = @json($isOnLastPage);
    </script>

    <script type="text/javascript" src="{{ mix('js/bitcoin-page.js') }}"></script>
@endpush
