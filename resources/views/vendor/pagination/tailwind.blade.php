{{-- resources/views/vendor/pagination/tailwind.blade.php --}}

<div class="flex items-center justify-between">
    <div class="flex items-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-500 cursor-not-allowed">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 text-gray-300 hover:text-white hover:bg-gray-700 rounded transition">{{ __('«') }}</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-purple-700 text-white rounded font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 text-gray-300 hover:text-white hover:bg-gray-700 rounded transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 text-gray-300 hover:text-white hover:bg-gray-700 rounded transition">{{ __('»') }}</a>
        @else
            <span class="px-3 py-1 text-gray-500 cursor-not-allowed">&raquo;</span>
        @endif
    </div>

    <div class="text-sm text-gray-400">
        Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }} dari {{ $paginator->total() }} pengguna
    </div>
</div>