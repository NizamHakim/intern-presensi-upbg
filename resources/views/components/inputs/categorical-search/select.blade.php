<div {{ $attributes->merge(['class' => 'categorical-search input-outline flex min-w-0 flex-row rounded-sm-md shadow-sm']) }}>
  <div class="relative w-24">
    <button type="button" class="categorical-search-button relative flex h-full w-full min-w-0 items-center justify-start rounded-l-sm-md bg-upbg focus:outline-transparent">
      <span class="categorical-search-text truncate pl-2 pr-4 text-white">{{ $text }}</span>
      <i class="fa-solid fa-chevron-down categorical-search-icon absolute right-3 top-1/2 -translate-y-1/2 transform text-xs text-white transition"></i>
    </button>

    <ul class="categorical-search-options-container absolute -bottom-1 z-10 hidden max-h-40 w-full translate-y-full overflow-auto rounded-md border bg-white opacity-0 shadow-strong transition md:max-h-52">
      {{ $slot }}
    </ul>
  </div>

  <input type="search" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ $search }}" class="categorical-search-input flex-1 rounded-r-sm-md px-2 py-2 outline-none">
</div>

@pushOnce('script')
  <script src="{{ asset('js/views/components/inputs/categorical-search/select.js') }}"></script>
@endPushOnce
