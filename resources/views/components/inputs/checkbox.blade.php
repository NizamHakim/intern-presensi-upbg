<div class="inline-flex items-center">
    <label class="flex items-center cursor-pointer relative">
        @php
            switch ($type) {
                case 'green':
                    $classes = 'checked:bg-green-600 checked:border-green-600';
                    break;
                case 'red':
                    $classes = 'checked:bg-red-600 checked:border-red-600';
                    break;
                case 'blue':
                    $classes = 'checked:bg-upbg checked:border-upbg';
                    break;
                default:
                    $classes = 'checked:bg-green-600 checked:border-green-600';
                    break;
            }
        @endphp
        <input {{ $attributes }} type="checkbox" @if($checked) checked @endif value="{{ $value }}" name="{{ $inputName }}" class="peer h-4 w-4 cursor-pointer transition-all appearance-none rounded border border-slate-300 {{ $classes }}">
        <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
        </span>
    </label>
</div> 