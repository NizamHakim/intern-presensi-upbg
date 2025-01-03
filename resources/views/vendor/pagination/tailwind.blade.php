<p class="pt-4 text-center text-sm text-gray-600 sm:text-left">Menampilkan <span class="font-semibold">{{ $paginator->count() }}</span> dari <span class="font-semibold">{{ $paginator->total() }}</span> hasil pencarian</p>
@if ($paginator->hasPages())
  <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="mt-6 flex items-center justify-between">
    <div class="flex flex-1 items-center justify-center gap-2">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <div aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
          <div class="flex items-center justify-center rounded-full bg-white p-3 font-medium text-gray-400" aria-hidden="true">
            <i class="fa-solid fa-arrow-left-long"></i>
          </div>
        </div>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center rounded-full bg-white p-3 font-medium text-gray-600 transition duration-150 ease-in-out hover:bg-gray-200" aria-label="{{ __('pagination.previous') }}">
          <i class="fa-solid fa-arrow-left-long"></i>
        </a>
      @endif

      <div class="flex flex-row items-center justify-center gap-2">
        @foreach ($elements as $element)
          {{-- Array Of Links --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <div aria-current="page" class="pagination-active @if ($page == 1) pagination-first @elseif ($page == $paginator->lastPage()) pagination-last @endif">
                  <span class="flex size-10 cursor-pointer items-center justify-center rounded-sm bg-upbg p-2 font-medium text-white hover:bg-upbg-dark">{{ $page }}</span>
                </div>
              @else
                <a href="{{ $url }}" class="@if ($page == 1) pagination-first @elseif ($page == $paginator->lastPage()) pagination-last @else pagination-item @endif hidden size-10 items-center justify-center rounded-sm bg-white p-2 font-medium text-gray-600 transition duration-150 ease-in-out hover:bg-gray-200" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                  {{ $page }}
                </a>
              @endif
            @endforeach
          @endif
        @endforeach
      </div>

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center rounded-full bg-white p-3 font-medium text-gray-600 transition duration-150 ease-in-out hover:bg-gray-200" aria-label="{{ __('pagination.next') }}">
          <i class="fa-solid fa-arrow-right-long"></i>
        </a>
      @else
        <div aria-disabled="true" aria-label="{{ __('pagination.next') }}">
          <div class="flex items-center justify-center rounded-full bg-white p-3 font-medium text-gray-400" aria-hidden="true">
            <i class="fa-solid fa-arrow-right-long"></i>
          </div>
        </div>
      @endif
    </div>
  </nav>
  @pushOnce('script')
    <script src="{{ asset('js/views/vendor/paginationStyle.js') }}"></script>
  @endPushOnce
@endif
