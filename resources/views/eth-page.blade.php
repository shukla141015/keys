@extends('layout.base-template', [
    'title'       => __($isOnFirstPage ? 'seo.title.eth-first-page'       : ($isOnLastPage ? 'seo.title.eth-last-page'       : 'seo.title.eth-page')),
    'description' => __($isOnFirstPage ? 'seo.description.eth-first-page' : ($isOnLastPage ? 'seo.description.eth-last-page' : 'seo.description.eth-page')),
    'keywords'    => __('seo.keywords.eth-page'),
])

@if(! $isOnFirstPage && ! $isOnLastPage)
    @include('helpers.robots-noindex')
@endif

@section('content')

    @include('components.key-page-header', ['routeBase' => 'ethPages', 'coinName' => 'Ethereum'])

    @if($isOnFirstPage || $isOnLastPage)
        <p class="mb-4 max-w-md mx-auto leading-normal text-center">
            @if ($isOnFirstPage)
                This is the first page of ethereum private keys. There are 128 wallets on this page.
                <br>
                Every row shows a private key and a public key.
            @elseif($isOnLastPage)
                This is the last page of ethereum private keys. There are 96 wallets on this page.
                <br>
                Every row shows a private key and a public key.
            @endif
        </p>
    @endif


    @include('components.ads.key-page-top')


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


    @include('components.ads.key-page-bottom')


    <div class="mt-8 text-xs text-center">
        Ethereum balance checker is powered by <a href="https://etherscan.io/" rel="nofollow" target="_blank">Etherscan.io</a>
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
