<div data-default-text="{{ $selected['text'] }}" 
    data-default-value="{{ $selected['value'] }}" 
    @if ($placeholder) data-placeholder="{{ $placeholder }}" @endif 
    {{ $attributes->merge(['class' => 'w-full relative input-dropdown ']) }}>

    <button type="button" class="dropdown-button relative w-full pl-3 pr-8 h-10 grid justify-start items-center rounded-md bg-gray-200 outline outline-1.5 outline-transparent outline-offset-0 transition-all hover:bg-gray-300">
        <span class="dropdown-text text-gray-600 font-medium truncate @if($selected['value'] == '') isnull @endif">{{ $selected['text'] }}</span>
        <i class="fa-solid fa-chevron-down dropdown-icon text-gray-600 text-xs transition absolute top-1/2 transform -translate-y-1/2 right-3"></i>
    </button>

    <input type="hidden" name="{{ $name }}" value="{{ $selected['value'] }}">

    <ul class="dropdown-options-container hidden opacity-0 absolute -bottom-1 translate-y-full w-full bg-white transition shadow-strong border rounded-md z-10 max-h-52 overflow-auto">
        <li class="w-full px-3 py-2 rounded-t-md"><input type="text" class="dropdown-search w-full px-2 py-1.5 border rounded-md outline-none bg-gray-100" placeholder="Search..."></li>
        @if ($placeholder)
            <x-inputs.dropdown.option value="" class="{{ ($selected['value'] == '') ? 'selected' : '' }}">{{ $placeholder }}</x-inputs.dropdown.option>
        @endif
        {{ $slot }}
    </ul>
</div>

@pushOnce('script')
    <script src="{{ asset('js/views/components/inputs/dropdown/select.js') }}"></script>
@endPushOnce

{{--  
<x-inputs.dropdown.select name="name" placeholder="placeholder" :selected="['text', 'value'] or null" class="optional">
    @foreach ($options as $option)
        <x-inputs.dropdown.option :value="$optionvalue" class="{{ 'selected' or '' }}">{{ "optiondisplaytext" }}</x-inputs.dropdown.option>
    @endforeach
</x-inputs.dropdown.select> 
--}}