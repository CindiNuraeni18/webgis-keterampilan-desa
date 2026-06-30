@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        
     <div class="d-flex flex-fill justify-content-end pagination-mobile">

    <div class="text-end">

        <ul class="pagination mb-2">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link"
                       href="{{ $paginator->previousPageUrl() }}">
                        &lsaquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        @if ($page == $paginator->currentPage())

                            <li class="page-item active">
                                <span class="page-link">
                                    {{ $page }}
                                </span>
                            </li>

                        @else

                            <li class="page-item">
                                <a class="page-link"
                                   href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>

                        @endif

                    @endforeach
                @endif

            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link"
                       href="{{ $paginator->nextPageUrl() }}">
                        &rsaquo;
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        &rsaquo;
                    </span>
                </li>
            @endif

        </ul>

        <p class="small text-muted mb-0">
            <span>
                {{ $paginator->firstItem() }}
                -
                {{ $paginator->lastItem() }}
            </span>

            dari

            <span>
                {{ $paginator->total() }}
            </span>

            data

        </p>

    </div>

</div>
    </nav>
@endif
