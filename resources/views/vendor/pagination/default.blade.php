@if ($paginator->hasPages())
<div class="pagination-wrap">
    <div class="pagination-info">
        Menampilkan
        <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong>
        dari <strong>{{ $paginator->total() }}</strong> data
    </div>
    <ul class="pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <span><i class="fas fa-chevron-left" style="font-size:0.7rem;"></i></span>
            </li>
        @else
            <li class="prev">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">
                    <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i>
                </a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="next">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">
                    <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
                </a>
            </li>
        @else
            <li class="disabled">
                <span><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></span>
            </li>
        @endif
    </ul>
</div>
@endif
