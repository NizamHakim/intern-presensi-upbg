<div data-default-text="{{ $selected['text'] }}" data-default-value="{{ $selected['value'] }}" {{ $attributes->merge(['class' => 'w-full input-group input-dropdown ']) }}>
    @if ($label)
        <label class="block font-medium text-sm mb-1.5 text-gray-600">{{ $label }}</label>
    @endif

    <div class="dropdown-content relative">
        <button type="button" class="dropdown-button w-full px-3 h-10 flex flex-row justify-between items-center rounded-md bg-gray-200 outline outline-1.5 outline-transparent outline-offset-0 transition-all hover:bg-gray-300">
            <span class="@if($selected['value'] !== null) text-gray-600 @else text-gray-400 @endif font-medium truncate">{{ $selected['text'] }}</span>
            <i class="fa-solid fa-chevron-down text-gray-600 text-xs transition"></i>
        </button>
    
        <input type="hidden" name="{{ $inputName }}" value="{{ $selected['value'] }}">
    
        <ul class="dropdown-options-container hidden opacity-0 absolute -bottom-1 translate-y-full w-full bg-white transition shadow-strong border rounded-md z-10 max-h-52 overflow-auto">
            <li class="w-full px-3 py-2 rounded-t-md"><input type="text" class="dropdown-search w-full px-2 py-1.5 border rounded-md outline-none bg-gray-100" placeholder="Search..."></li>
            @foreach ($options as $option)
                <li data-value="{{ $option['value'] }}" class="dropdown-option px-2 py-2 cursor-pointer hover:bg-gray-200 border-l-4 truncate last:rounded-b-md @if($option['value'] === $selected['value']) border-upbg @else border-transparent @endif">{{ $option['text'] }}</li>
            @endforeach
        </ul>
    </div>
</div>

@pushOnce('script')
    <script src="{{ asset('js/views/components/inputs/dropdown.js') }}"></script>
@endPushOnce