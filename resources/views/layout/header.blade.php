<nav class="flex justify-around items-center py-2 mb-4 bg-white shadow">

    <div>
        <a href="/" class="flex items-center text-black font-mono font-bold text-xl">
            <img class="h-6 mr-2 inline-block" src="/favicon.png" alt="Keys.lol">
            Keys.lol
        </a>
    </div>

    <div class="flex items-center justify-between" title="Bitcoin keys">
        <a class="flex items-center text-black p-1 ml-4 sm:ml-6" href="{{ route('btcPages.index') }}">
            <span class="h-6 w-6 mr-2">@include('components.svg.bitcoin')</span>
        </a>

        <a class="flex items-center text-black p-1 ml-4 sm:ml-6" href="{{ route('ethPages.index') }}" title="Ethereum keys">
            <span class="h-4 w-4 mr-2 -mt-2">@include('components.svg.ethereum')</span>
        </a>

        {{--<a class="flex items-center text-black p-1 ml-4 sm:ml-6" href="/" title="Litecoin keys">--}}
            {{--<span class="h-6 w-6 mr-2">@include('components.svg.litecoin')</span>--}}
        {{--</a>--}}

        {{--<a class="flex items-center text-black p-1 ml-4 sm:ml-6" href="/" title="Neo keys">--}}
            {{--<span class="h-6 w-6 mr-2">@include('components.svg.neo')</span>--}}
        {{--</a>--}}
    </div>

</nav>

@if(Route::is('btcPages*'))
    <span class="selected-coin w-10 h-10 lg:inline hidden">
        @include('components.svg.bitcoin')
    </span>
@elseif(Route::is('ethPages*'))
    <span class="selected-coin w-8 h-8 -mt-2 lg:inline hidden">
        @include('components.svg.ethereum')
    </span>
@endif

<div id="adblock-banner" style="display: none;" class="bg-red-light text-white text-center mx-auto max-w-md rounded py-2 px-4 my-2">
    If the balance of the wallets is not being checked, try disabling your adblocker
</div>
