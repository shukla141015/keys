<div class="flex justify-between items-center max-w-sm mx-auto">
    @if($includeFirstAndLast ?? true)
        <a title="{{ $isOnFirstPage ? 'You are on the first page' : 'First page' }}" class="text-black {{ $isOnFirstPage ? 'cursor-not-allowed' : '' }}" href="{{ $isOnFirstPage ? 'javascript:' : route($routeBase, 1) }}">
            <span class="inline-block w-6 rotate-180">@include('components.svg.angle-double-right')</span>
        </a>
    @endif


    <a title="{{ $isOnFirstPage ? 'You are on the first page' : 'Previous page' }}" class="text-black {{ $isOnFirstPage ? 'cursor-not-allowed' : '' }}" rel="nofollow" href="{{ $isOnFirstPage ? 'javascript:' : route($routeBase, $previousPage) }}">
        <span class="inline-block w-4 rotate-180">@include('components.svg.angle-right')</span>
    </a>


    <a title="Random page" class="text-black " rel="nofollow" href="{{ route($routeBase.'.random') }}">
        <span class="inline-block w-8">@include('components.svg.random')</span>
    </a>


    <a title="{{ $isOnLastPage ? 'You are on the last page' : 'Next page' }}" class="text-black {{ $isOnLastPage ? 'cursor-not-allowed' : '' }}" rel="nofollow" href="{{ $isOnLastPage ? 'javascript:' : route($routeBase, $nextPage) }}">
        <span class="inline-block w-4">@include('components.svg.angle-right')</span>
    </a>


    @if($includeFirstAndLast ?? true)
        <a title="{{ $isOnLastPage ? 'You are on the last page' : 'Last page' }}" class="text-black {{ $isOnLastPage ? 'cursor-not-allowed' : '' }}" href="{{ $isOnLastPage ? 'javascript:' : route($routeBase, $lastPage) }}">
            <span class="inline-block w-6">@include('components.svg.angle-double-right')</span>
        </a>
    @endif
</div>
