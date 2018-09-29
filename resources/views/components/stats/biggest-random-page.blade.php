<div class="max-w-lg font-mono text-xs overflow-x-auto whitespace-no-wrap mb-4">
    @foreach($biggestPages as $biggestPage)
        @if($loop->first)
            Last page number: &nbsp;&nbsp;&nbsp;{{ $maxPage }}
            <br>
            Current biggest: &nbsp;&nbsp;&nbsp;&nbsp;{{ str_pad($biggestPage->page_number, strlen($maxPage), '0', STR_PAD_LEFT) }}
            <br>
            Difference:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ str_pad(string_subtract($maxPage, $biggestPage->page_number), strlen($maxPage), '0', STR_PAD_LEFT) }}
            <br><br>
        @endif

        {{ $biggestPage->created_at->format('Y-m-d H:i') }} {!! $hideCoin ? '&nbsp;&nbsp;&nbsp;' : $biggestPage->coin !!} {{ str_pad($biggestPage->page_number, strlen($maxPage), '0', STR_PAD_LEFT) }}
        <br>
    @endforeach
</div>
