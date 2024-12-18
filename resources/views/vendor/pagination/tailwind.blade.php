@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between mt-6">
        <div class="flex-1 flex items-center justify-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <div aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <div class="flex justify-center items-center p-3 rounded-full font-medium text-gray-400 bg-white" aria-hidden="true">
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </div>
                </div>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex justify-center items-center p-3 rounded-full font-medium text-gray-600 bg-white hover:bg-gray-200 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
            @endif
        
            <div class="flex flex-row justify-center items-center gap-2">
                @foreach ($elements as $element)    
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <div aria-current="page" class="pagination-active @if ($page == 1) pagination-first @elseif ($page == $paginator->lastPage()) pagination-last @endif">
                                    <span class="flex justify-center items-center p-2 size-10 rounded-sm font-medium text-white bg-upbg hover:bg-upbg-dark cursor-pointer">{{ $page }}</span>
                                </div>
                            @else
                                <a href="{{ $url }}" 
                                    class="@if ($page == 1) pagination-first @elseif ($page == $paginator->lastPage()) pagination-last @else pagination-item @endif hidden justify-center items-center p-2 size-10 rounded-sm font-medium text-gray-600 bg-white hover:bg-gray-200 transition ease-in-out duration-150" 
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach 
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex justify-center items-center p-3 rounded-full font-medium text-gray-600 bg-white hover:bg-gray-200 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                    <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            @else
                <div aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <div class="flex justify-center items-center p-3 rounded-full font-medium text-gray-400 bg-white" aria-hidden="true">
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </div>
                </div>
            @endif
        </div>
    </nav>
    @push('script')
        <script src="{{ asset('js/views/vendor/paginationStyle.js') }}"></script>
    @endpush
@endif
