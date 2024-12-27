<div data-plugin="{{ $plugin }}" data-default="{{ $value }}" {{ $attributes->merge(['class' => 'flex flex-col w-full input-date ']) }}>
  <div class="relative">
    <input type="date" name="{{ $inputName }}" value="{{ $value }}" placeholder="{{ $placeholder }}" class="input-appearance input-outline w-full cursor-pointer truncate placeholder:text-gray-400">
    <i class="fa-solid fa-calendar-days pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 transform cursor-pointer text-sm text-gray-600"></i>
  </div>
</div>

@pushOnce('script')
  <script src="{{ asset('js/views/components/inputs/date.js') }}"></script>
@endPushOnce
