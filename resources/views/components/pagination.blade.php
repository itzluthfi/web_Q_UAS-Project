@props(['pagination', 'baseUrl'])

@if(isset($pagination['current_page'], $pagination['last_visible_page']) && $pagination['last_visible_page'] > 1)
<style>
    /* Pagination Container */
    .pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    /* Base Button Styles */
    .pagination-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        background-color: #ffffff;
        color: #374151;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .pagination-btn:hover {
        background-color: #f9fafb;
        border-color: #d1d5db;
        color: #111827;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .pagination-btn:focus {
        outline: none;
        ring: 2px;
        ring-color: #8b5cf6;
        ring-offset: 2px;
    }

    /* Navigation Buttons (Previous/Next) - Purple Theme */
    .pagination-nav-btn {
        padding: 0.5rem 1rem;
        font-weight: 600;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        border: none;
        box-shadow: 0 2px 4px rgba(139, 92, 246, 0.2);
    }

    .pagination-nav-btn:hover {
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(139, 92, 246, 0.3);
    }

    /* Number Buttons */
    .pagination-number-btn {
        background-color: #ffffff;
        border-color: #e5e7eb;
    }

    .pagination-number-btn:hover {
        background-color: #faf5ff;
        border-color: #8b5cf6;
        color: #7c3aed;
    }

    /* Current Page Button - Purple Theme */
    .pagination-current {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        border-color: #8b5cf6;
        font-weight: 700;
        box-shadow: 0 4px 8px rgba(139, 92, 246, 0.4);
        cursor: default;
    }

    .pagination-current:hover {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        transform: none;
    }

    /* Disabled Button */
    .pagination-disabled {
        background-color: #f9fafb;
        color: #9ca3af;
        border-color: #e5e7eb;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .pagination-disabled:hover {
        background-color: #f9fafb;
        color: #9ca3af;
        transform: none;
        box-shadow: none;
    }

    /* Dots */
    .pagination-dots {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        color: #a855f7;
        font-weight: 600;
        font-size: 1rem;
    }

    /* Page Info */
    .pagination-container .text-sm {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
        padding: 0.5rem 1rem;
        background-color: #faf5ff;
        border-radius: 0.5rem;
        border: 1px solid #e9d5ff;
    }

    /* Responsive Design */
    @media (max-width: 640px) {
        .pagination-btn {
            min-width: 2rem;
            height: 2rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .pagination-nav-btn {
            padding: 0.25rem 0.5rem;
        }
        
        .pagination-container {
            gap: 0.75rem;
        }
        
        .flex.items-center.space-x-1 {
            gap: 0.25rem;
        }
        
        .flex.items-center.space-x-1.mx-2 {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            gap: 0.25rem;
        }
    }

    /* Dark Mode Support - Purple Theme */
    @media (prefers-color-scheme: dark) {
        .pagination-btn {
            background-color: #1f2937;
            border-color: #374151;
            color: #e5e7eb;
        }
        
        .pagination-btn:hover {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }
        
        .pagination-number-btn:hover {
            background-color: #581c87;
            border-color: #8b5cf6;
            color: #c4b5fd;
        }
        
        .pagination-disabled {
            background-color: #111827;
            color: #6b7280;
            border-color: #374151;
        }
        
        .pagination-container .text-sm {
            color: #9ca3af;
            background-color: #1f2937;
            border-color: #374151;
        }

        .pagination-dots {
            color: #a855f7;
        }
    }

    /* Animation for smooth transitions */
    .pagination-btn svg {
        transition: transform 0.2s ease-in-out;
    }

    /* Hover effects for icons */
    .group:hover .group-hover\:-translate-x-1 {
        transform: translateX(-0.25rem);
    }

    .group:hover .group-hover\:translate-x-1 {
        transform: translateX(0.25rem);
    }

    /* Focus states for accessibility - Purple Theme */
    .pagination-btn:focus-visible {
        outline: 2px solid #8b5cf6;
        outline-offset: 2px;
    }

    /* Loading state (optional) - Purple Theme */
    .pagination-loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .pagination-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 1rem;
        height: 1rem;
        margin: -0.5rem 0 0 -0.5rem;
        border: 2px solid #e5e7eb;
        border-top-color: #8b5cf6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

    <div class="mt-12 flex justify-center">
        <nav class="pagination-container" aria-label="Pagination Navigation">
            <div class="flex items-center space-x-1">
                {{-- Tombol Sebelumnya --}}
                @php
                    $prevQuery = request()->query();
                    $prevQuery['page'] = $pagination['current_page'] - 1;
                    $prevUrl = $baseUrl . '?' . http_build_query($prevQuery);

                    $nextQuery = request()->query();
                    $nextQuery['page'] = $pagination['current_page'] + 1;
                    $nextUrl = $baseUrl . '?' . http_build_query($nextQuery);
                @endphp

                @if($pagination['current_page'] > 1)
                    <a href="{{ $prevUrl }}" class="pagination-btn pagination-nav-btn group" aria-label="Halaman sebelumnya">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span class="hidden sm:inline ml-1">Sebelumnya</span>
                    </a>
                @else
                    <span class="pagination-btn pagination-disabled" aria-label="Halaman sebelumnya tidak tersedia">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span class="hidden sm:inline ml-1">Sebelumnya</span>
                    </span>
                @endif

                {{-- Nomor Halaman --}}
                <div class="flex items-center space-x-1 mx-2">
                    @php
                        $start = max(1, $pagination['current_page'] - 2);
                        $end = min($pagination['last_visible_page'], $pagination['current_page'] + 2);
                        if ($end - $start < 4) {
                            if ($start == 1) {
                                $end = min($pagination['last_visible_page'], $start + 4);
                            } else {
                                $start = max(1, $end - 4);
                            }
                        }
                    @endphp

                    @if($start > 1)
                        @php
                            $firstPageQuery = request()->query();
                            $firstPageQuery['page'] = 1;
                            $firstPageUrl = $baseUrl . '?' . http_build_query($firstPageQuery);
                        @endphp
                        <a href="{{ $firstPageUrl }}" class="pagination-btn pagination-number-btn" aria-label="Halaman 1">1</a>
                        @if($start > 2)
                            <span class="pagination-dots" aria-hidden="true">...</span>
                        @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        @php
                            $pageQuery = request()->query();
                            $pageQuery['page'] = $i;
                            $pageUrl = $baseUrl . '?' . http_build_query($pageQuery);
                        @endphp

                        @if($i == $pagination['current_page'])
                            <span class="pagination-btn pagination-current" aria-current="page" aria-label="Halaman {{ $i }}, halaman saat ini">{{ $i }}</span>
                        @else
                            <a href="{{ $pageUrl }}" class="pagination-btn pagination-number-btn" aria-label="Halaman {{ $i }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($end < $pagination['last_visible_page'])
                        @if($end < $pagination['last_visible_page'] - 1)
                            <span class="pagination-dots" aria-hidden="true">...</span>
                        @endif
                        @php
                            $lastPageQuery = request()->query();
                            $lastPageQuery['page'] = $pagination['last_visible_page'];
                            $lastPageUrl = $baseUrl . '?' . http_build_query($lastPageQuery);
                        @endphp
                        <a href="{{ $lastPageUrl }}" class="pagination-btn pagination-number-btn" aria-label="Halaman {{ $pagination['last_visible_page'] }}">{{ $pagination['last_visible_page'] }}</a>
                    @endif
                </div>

                {{-- Tombol Selanjutnya --}}
                @if($pagination['current_page'] < $pagination['last_visible_page'])
                    <a href="{{ $nextUrl }}" class="pagination-btn pagination-nav-btn group" aria-label="Halaman selanjutnya">
                        <span class="hidden sm:inline mr-1">Selanjutnya</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <span class="pagination-btn pagination-disabled" aria-label="Halaman selanjutnya tidak tersedia">
                        <span class="hidden sm:inline mr-1">Selanjutnya</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                @endif
            </div>

            {{-- Info halaman --}}
            <div class="mt-4 text-center">
                <span class="text-sm text-gray-400">
                    Halaman {{ $pagination['current_page'] }} dari {{ $pagination['last_visible_page'] }}
                </span>
            </div>
        </nav>
    </div>
@endif