<nav class="flex items-center p-2 mb-4 max-w-3xl mx-auto">

    <a href="/" class="flex items-center text-black mr-16">
        <img class="h-6 mr-2" src="/favicon.png" alt="Keys.lol">
        Keys.lol
    </a>

    <a class="flex items-center text-black p-1 ml-6 {{ Route::is('btcPages*') ? 'font-bold' : '' }}" href="{{ route('btcPages', 1) }}">
        <span class="h-6 w-6 mr-2">@include('components.svg.bitcoin')</span>
        bitcoin keys
    </a>

    <a class="flex items-center text-black p-1 ml-6" href="/">
        <span class="h-4 w-4 -mt-2 mr-2">@include('components.svg.ethereum')</span>
        ethereum keys
    </a>

    <a class="flex items-center text-black p-1 ml-6" href="/">
        <span class="h-6 w-6 mr-2">@include('components.svg.litecoin')</span>
        litecoin keys
    </a>

    <a class="flex items-center text-black p-1 ml-6" href="/">
        <span class="h-6 w-6 mr-2">@include('components.svg.neo')</span>
        neo keys
    </a>

</nav>
