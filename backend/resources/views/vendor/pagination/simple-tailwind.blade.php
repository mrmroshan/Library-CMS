@if ($paginator->hasPages())
    <nav class="pagination-nav" role="navigation" aria-label="Pagination Navigation">
        <div class="pagination-list">
            @if ($paginator->onFirstPage())
                <span class="pagination-link pagination-disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">&laquo; Previous</span>
            @else
                <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo; Previous</a>
            @endif

            @if ($paginator->hasMorePages())
                <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next &raquo;</a>
            @else
                <span class="pagination-link pagination-disabled" aria-disabled="true" aria-label="@lang('pagination.next')">Next &raquo;</span>
            @endif
        </div>
    </nav>
@endif
