<div data-default-text="{{ $text }}" data-default-value="{{ $value }}" @if ($placeholder) data-placeholder="{{ $placeholder }}" @endif {{ $attributes->merge(['class' => 'w-full relative input-dropdown ' . ($value == '' ? 'is-null' : '')]) }}>

  <button type="button" class="dropdown-button input-appearance input-outline relative flex w-full min-w-0 items-center justify-start rounded-sm-md focus:outline-transparent">
    <span class="dropdown-text truncate pr-4 text-gray-600">{{ $text }}</span>
    <i class="fa-solid fa-chevron-down dropdown-icon absolute right-3 top-1/2 -translate-y-1/2 transform text-xs text-gray-600 transition"></i>
  </button>

  <input type="hidden" name="{{ $name }}" value="{{ $value }}">

  <ul class="dropdown-options-container absolute -bottom-1 z-10 hidden max-h-40 w-full translate-y-full overflow-auto rounded-md border bg-white opacity-0 shadow-strong transition md:max-h-52">
    <li class="w-full rounded-t-md px-3 py-2"><input type="text" class="dropdown-search w-full rounded-md border bg-gray-100 px-2 py-1.5 outline-none" placeholder="Search..."></li>
    @if ($placeholder)
      <x-inputs.dropdown.option value="" class="{{ $value == '' ? 'selected' : '' }}">{{ $placeholder }}</x-inputs.dropdown.option>
    @endif
    {{ $slot }}
  </ul>
</div>

@pushOnce('script')
  <script src="{{ asset('js/views/components/inputs/dropdown/select.js') }}"></script>
@endPushOnce
