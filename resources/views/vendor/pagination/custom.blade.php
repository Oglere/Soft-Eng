@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="inline-flex items-center">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="pagination-btn disabled">&laquo;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn">&laquo;</a>
    @endif

    {{-- Page Links --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="pagination-btn disabled">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="pagination-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn">&raquo;</a>
    @else
        <span class="pagination-btn disabled">&raquo;</span>
    @endif
</nav>
@endif
