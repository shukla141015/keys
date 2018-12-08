<div class="max-w-lg font-mono text-xs overflow-x-auto whitespace-no-wrap mb-4">
    @foreach($smallestPages as $smallestPage)
        {{ $smallestPage->created_at->format('Y-m-d H:i') }} {!! $hideCoin ? '&nbsp;&nbsp;&nbsp;' : $smallestPage->coin !!} {!! print_smallest_page_number($smallestPage->page_number, $maxPage) !!}
        <br>
    @endforeach
</div>
