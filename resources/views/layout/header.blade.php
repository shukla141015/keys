<nav class="flex items-center p-2 mb-4 max-w-3xl mx-auto">

    <a href="/" class="flex items-center text-black mr-4 sm:mr-16">
        <img class="h-6 mr-2 hidden sm:inline-block" src="/favicon.png" alt="Keys.lol">
        Keys.lol
    </a>

    <a class="flex items-center text-black p-1 ml-4 sm:ml-6 {{ Route::is('btcPages*') ? 'font-bold' : '' }}" href="{{ route('btcPages', 1) }}">
        <span class="h-6 w-6 mr-2">@include('components.svg.bitcoin')</span>
        <span class="md:inline-block hidden">bitcoin keys</span>
    </a>

    <a class="flex items-center text-black p-1 ml-4 sm:ml-6" href="/">
        <span class="h-4 w-4 -mt-2 mr-2">@include('components.svg.ethereum')</span>
        <span class="md:inline-block hidden">ethereum keys</span>
    </a>

    <a class="flex items-center text-black p-1 ml-4 sm:ml-6" href="/">
        <span class="h-6 w-6 mr-2">@include('components.svg.litecoin')</span>
        <span class="md:inline-block hidden">litecoin keys</span>
    </a>

    <a class="flex items-center text-black p-1 ml-4 sm:ml-6" href="/">
        <span class="h-6 w-6 mr-2">@include('components.svg.neo')</span>
        <span class="md:inline-block hidden">neo keys</span>
    </a>

</nav>
