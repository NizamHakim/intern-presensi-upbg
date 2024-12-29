@php
  switch ($type) {
      case 'green':
          $color = 'checkbox-green';
          break;
      case 'red':
          $color = 'checkbox-red';
          break;
      case 'blue':
          $color = 'checkbox-upbg';
          break;
  }
@endphp
<label {{ $attributes->merge(['class' => 'checkbox ' . $color . ' inline-flex cursor-pointer items-center gap-2']) }} {{ $attributes }} data-checked-origin="{{ $checked ? 1 : 0 }}">
  <div class="relative flex items-center">
    <input type="checkbox" @if ($checked) checked @endif value="{{ $value }}" name="{{ $inputName }}" class="peer h-4 w-4 cursor-pointer appearance-none rounded-sm-md border border-slate-300 bg-white transition-all">
    <span class="checkmark pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 transform opacity-0 peer-checked:opacity-100">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
      </svg>
    </span>
  </div>
  <span class="checkbox-label select-none">{{ $slot }}</span>
</label>
