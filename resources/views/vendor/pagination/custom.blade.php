@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center" style="gap: 5px;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="btn btn-sm btn-secondary">«</span>
                </li>
            @else
                <li class="page-item">
                    <a class="btn btn-sm btn-primary" href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="btn btn-sm btn-light">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="btn btn-sm btn-primary">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="btn btn-sm btn-outline-primary" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="btn btn-sm btn-primary" href="{{ $paginator->nextPageUrl() }}" rel="next">»</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="btn btn-sm btn-secondary">»</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
