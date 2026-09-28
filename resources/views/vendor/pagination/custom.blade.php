@if ($paginator->hasPages())
    <!-- flex-col + items-center + text-center untuk meletakkan semua elemen di tengah -->
    <div class="flex flex-col items-center justify-center text-center gap-3 mt-8">
        
        {{-- Counter Text --}}
        <p class="text-default-500 text-sm">
            Menampilkan <b>{{ sprintf('%02d', $paginator->firstItem() ?? 0) }}</b> - <b>{{ sprintf('%02d', $paginator->lastItem() ?? 0) }}</b> of <b>{{ sprintf('%02d', $paginator->total()) }}</b> Hasil
        </p>

        {{-- Navigation Links --}}
        <nav aria-label="Pagination" class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button
                    class="btn btn-sm border bg-transparent border-default-200 text-default-400 cursor-not-allowed opacity-50"
                    type="button" disabled>
                    <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10 inline-flex items-center">
                    <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="btn size-7.5 bg-transparent text-default-400 cursor-default flex items-center justify-center">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="btn size-7.5 bg-primary text-white flex items-center justify-center font-semibold rounded">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="btn size-7.5 bg-transparent border border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10 flex items-center justify-center rounded transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10 inline-flex items-center">
                    Next <i class="size-4 ms-1" data-lucide="chevron-right"></i>
                </a>
            @else
                <button
                    class="btn btn-sm border bg-transparent border-default-200 text-default-400 cursor-not-allowed opacity-50"
                    type="button" disabled>
                    Next <i class="size-4 ms-1" data-lucide="chevron-right"></i>
                </button>
            @endif
        </nav>
    </div>
@endif