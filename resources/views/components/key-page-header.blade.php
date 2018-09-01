<div class="max-w-md mx-auto mt-4">
    <h1 class="flex flex-col text-base break-words text-center">
        <span>{{ $coinName }} keys page</span>
        <span class="text-sm my-1">{{ $pageNumber }}</span>
        <span>of</span>
        <span class="text-sm my-1">{{ $lastPage }}</span>
    </h1>

    <div class="my-4">
        @include('components.key-page-pagination', ['routeBase' => $routeBase])
    </div>
</div>
