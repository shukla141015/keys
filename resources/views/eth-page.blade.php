@extends('layout.base-template', [
    'title' => ($isOnFirstPage || $isOnLastPage)
                  ? ($isOnFirstPage
                      ? 'First page of ethereum private keys'
                      : 'Last page of ethereum private keys')
                  : 'Ethereum private keys'.($isShortNumberString ? ' - page '.$pageNumber : ''),

    'description' => '128 ethereum private keys with automatic balance checker. A database of all ethereum private keys.',
])

@if(! $isOnFirstPage && ! $isOnLastPage)
    @include('helpers.robots-noindex')
@endif

@section('content')

    @include('components.key-page-header', ['routeBase' => 'ethPages', 'coinName' => 'Ethereum'])

    @if($isOnFirstPage || $isOnLastPage)
        <p class="mb-4 max-w-md mx-auto leading-normal text-center">
            @if ($isOnFirstPage)
                This is the first page of ethereum private keys
                <br>
                This page has 128 private and public keys on it
            @elseif($isOnLastPage)
                This is the last page of ethereum private keys
                <br>
                This page only has 96 private and public keys on it
            @endif
        </p>
    @endif


    <div class="md:flex justify-center">
        <div>
        @foreach($keys as $key)
            <div id="{{ $key['publicKey'] }}" class="wallet loading flex flex-col lg:flex-row font-mono text-sm pl-2 py-1 lg:py-0">

                <span class="mr-0 md:mr-4 inline-block">
                    <strong class="wallet-balance">0 eth</strong>

                    <span class="text-xs sm:text-sm break-words">{{ $key['privateKey'] }}</span>
                </span>

                <span class="inline-block">
                    <a class="break-words text-xs sm:text-sm" href="https://etherscan.io/address/{{ $key['publicKey'] }}" rel="nofollow" target="_blank">
                        {{ $key['publicKey'] }}
                    </a>
                </span>

            </div>
        @endforeach
        </div>
    </div>


    <div class="mt-8 mb-6">
        @include('components.key-page-pagination', ['routeBase' => 'ethPages', 'includeFirstAndLast' => false])
    </div>

@endsection


@push('footer')
    <script>
        const keys = @json($keys);
        const isOnFirstPage = @json($isOnFirstPage);
        const isOnLastPage = @json($isOnLastPage);
    </script>

    <script type="text/javascript" src="{{ mix('js/ethereum-page.js') }}"></script>
@endpush
