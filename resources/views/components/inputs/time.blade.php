<div data-default="{{ $value ? $value->isoFormat('HH:mm') : null }}" {{ $attributes->merge(['class' => 'relative flex flex-col w-full input-time ']) }}>
  <input type="time" name="{{ $inputName }}" value="{{ $value ? $value->isoFormat('HH:mm') : null }}" placeholder="{{ $placeholder }}" class="input-appearance input-outline w-full cursor-pointer truncate placeholder:text-gray-400">
  <i class="fa-regular fa-clock pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 transform cursor-pointer text-sm text-gray-600"></i>
</div>

@pushOnce('script')
  <script src="{{ asset('js/views/components/inputs/time.js') }}"></script>
@endPushOnce
