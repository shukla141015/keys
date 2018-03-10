<div class="flex justify-between my-4 max-w-md">
    @if($includeFirstAndLast ?? true)
        <a href="{{ route('btcPages', 1) }}">first page</a>
    @endif

    @if ($isOnFirstPage)
        <span class="cursor-not-allowed">previous page</span>
    @else
        <a href="{{ route('btcPages', $previousPage) }}">previous page</a>
    @endif

    <a href="{{ route('btcPages.random') }}">random page</a>

    @if ($isOnLastPage)
        <span class="cursor-not-allowed">next page</span>
    @else
        <a href="{{ route('btcPages', $nextPage) }}">next page</a>
    @endif

    @if($includeFirstAndLast ?? true)
        <a href="{{ route('btcPages', config('keys.bitcoin-max-page')) }}">last page</a>
    @endif
</div>
