<div class="inline-flex items-center">
    <label for="{{ $inputName }}" class="flex items-center cursor-pointer relative">
        <input id="{{ $inputName }}" name="{{ $inputName }}" value="{{ $value }}" type="checkbox" @if($checked) checked @endif {{ $attributes->merge(['class' => 'peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-gray-300']) }}/>
        <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
        </span>
    </label>
    @if ($label)
        <label for="{{ $inputName }}" class="cursor-pointer ml-2 text-gray-600 text-sm font-medium select-none"">{{ $label }}</label>
    @endif
</div>