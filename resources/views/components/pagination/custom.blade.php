@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-2 sm:space-y-0">
        {{-- Showing Text --}}
        <div class="text-sm text-gray-600">
            {!! __('Showing') !!}
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            {!! __('of') !!}
            <span class="font-medium">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </div>

        {{-- Navigation --}}
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center space-x-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-3 py-1 text-gray-700 bg-white border rounded hover:bg-gray-100">Previous</a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 text-white bg-blue-500 rounded">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-1 text-gray-700 bg-white border rounded hover:bg-gray-100">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-3 py-1 text-gray-700 bg-white border rounded hover:bg-gray-100">Next</a>
            @else
                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded">Next</span>
            @endif
        </nav>
    </div>
@endif
