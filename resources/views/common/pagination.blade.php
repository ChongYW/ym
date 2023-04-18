@if ($paginator->hasPages())
    <ul class="pagination" >
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">第一页</span></li>
        @else
            <li class="page-item"><a class="page-link"
                                     href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a></li>
        @endif

        {{-- Pagination Elements --}}

            {{-- "Three Dots" Separator --}}
            <li class="page-item active">
                <span class="page-link">第{{ $paginator->currentPage() }}/{{$paginator->lastPage()}}页</span></li>



        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link"
                                     href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a></li>
        @else
            <li class="page-item disabled"><span
                        class="page-link">最后一页</span></li>
        @endif
    </ul>
@endif