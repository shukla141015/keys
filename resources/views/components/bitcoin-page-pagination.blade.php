<div class="flex justify-between my-4 max-w-md">
    @if($includeFirstAndLast ?? true)
        <a title="first page" href="{{ route('btcPages', 1) }}">
            <span class="hidden md:inline-block">first page</span>
            <span class="md:hidden inline-block text-base">&#8676;</span>
        </a>
    @endif

    @if ($isOnFirstPage)
        <span title="previous page" class="cursor-not-allowed">
            <span class="hidden md:inline-block">previous page</span>
            <span class="md:hidden inline-block">&laquo;</span>
        </span>
    @else
        <a title="previous page" rel="nofollow" href="{{ route('btcPages', $previousPage) }}">
            <span class="hidden md:inline-block">previous page</span>
            <span class="md:hidden inline-block">&laquo;</span>
        </a>
    @endif

    <a title="random page" rel="nofollow" href="{{ route('btcPages.random') }}">
        <span class="hidden md:inline-block">random page</span>
        <span class="md:hidden inline-block w-4">@include('components.svg.random')</span>
    </a>

    @if ($isOnLastPage)
        <span title="next page" class="cursor-not-allowed">
            <span class="hidden md:inline-block">next page</span>
            <span class="md:hidden inline-block">&raquo;</span>
        </span>
    @else
        <a title="next page" rel="nofollow" href="{{ route('btcPages', $nextPage) }}">
            <span class="hidden md:inline-block">next page</span>
            <span class="md:hidden inline-block">&raquo;</span>
        </a>
    @endif

    @if($includeFirstAndLast ?? true)
        <a title="last page" href="{{ route('btcPages', config('keys.bitcoin-max-page')) }}">
            <span class="hidden md:inline-block">last page</span>
            <span class="md:hidden inline-block">&#8677;</span>
        </a>
    @endif
</div>
