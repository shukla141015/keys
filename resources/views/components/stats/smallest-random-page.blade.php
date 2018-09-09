<div class="max-w-lg font-mono text-xs overflow-x-auto whitespace-no-wrap mb-4">
    @foreach($smallestPages as $smallestPage)
        {{ $smallestPage->created_at->format('Y-m-d H:i') }} {!! $hideCoin ? '&nbsp;&nbsp;&nbsp;' : $smallestPage->coin !!} {{ str_pad($smallestPage->page_number, strlen($maxPage), '0', STR_PAD_LEFT) }}
        <br>
    @endforeach
</div>
