<div class="flex flex-col w-full">
    <label for="{{ $inputName }}" class="block font-medium text-sm mb-1.5 text-gray-600">{{ $label }}</label>
    <input id="{{ $inputName }}" 
        type="number" 
        name="{{ $inputName }}"
        value="{{ $value }}" 
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 rounded-md bg-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-offset-0 outline-1.5 transition-all focus:outline-upbg-light input-number']) }}
        placeholder="{{ $placeholder }}">
</div>