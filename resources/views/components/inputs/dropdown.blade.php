{{-- <div x-data="{ 
        showDropdown: false, 
        selected: @js($selected),
        searchQuery: '',
        options: @js($options), 
        get filteredOptions() {
            return this.options.filter(option => {
                return option.text.toLowerCase().includes(this.searchQuery.toLowerCase());
            });
        },
        openDropdown() {
            this.searchQuery = '';
            this.showDropdown = true;
            $nextTick(() => { this.$refs.searchBar.focus(); });
        },
        closeDropdown() {
            this.showDropdown = false;
        }
    }" 
    x-on:click.outside="closeDropdown()"
    {{ $attributes->merge(['class' => 'relative w-full input-dropdown']) }}>
    
    @if ($label)
        <label class="block font-medium text-sm mb-1.5 text-gray-600">{{ $label }}</label>
    @endif
    
    <button x-on:click="(!showDropdown) ? openDropdown() : closeDropdown()" 
        type="button" 
        class="w-full px-3 h-10 flex flex-row justify-between items-center rounded-md bg-gray-200 outline-1.5 outline-offset-0 transition-all hover:bg-gray-300 @if($style) {{ $style }} @endif"
        :class="(showDropdown) ? 'outline outline-upbg-light' : 'outline-transparent'">
        <span x-text="selected.text" :class="selected.value ? 'text-gray-600' : 'text-gray-400'" class="font-medium truncate"></span>
        <i :class="showDropdown ? 'rotate-180' : ''" class="fa-solid fa-chevron-down text-gray-600 text-xs transition"></i>
    </button>

    <input type="hidden" name="{{ $inputName }}" :value="selected.value">

    <ul x-cloak 
        x-show="showDropdown" 
        x-transition:enter="transition ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute -bottom-1 translate-y-full w-full bg-white transition shadow-strong border rounded-md z-10 max-h-52 overflow-auto">

        <li class="w-full px-3 py-2 rounded-t-md"><input x-ref="searchBar" x-model="searchQuery" type="text" class="w-full px-2 py-1.5 border rounded-md outline-none bg-gray-100" placeholder="Search..."></li>
        <template x-for="(option, index) in filteredOptions" :key="index">
            <li x-on:click="selected = option; closeDropdown()" 
                :class="[(selected.value == option.value) ? 'border-upbg' : 'border-transparent', index == filteredOptions.length - 1 ? 'rounded-b-md' : '']" 
                class="px-2 py-2 cursor-pointer hover:bg-gray-200 border-l-4 truncate" x-text="option.text"></li>
        </template>
    </ul>
</div> --}}

<div data-default-text="" data-default-value="" class="w-full input-group input-dropdown">
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
                <li data-value="{{ $option['value'] }}" class="dropdown-option px-2 py-2 cursor-pointer hover:bg-gray-200 border-l-4 truncate @if($option['value'] === $selected['value']) border-upbg @else border-transparent @endif @if ($loop->last) rounded-b-md @endif">{{ $option['text'] }}</li>
            @endforeach
        </ul>
    </div>
</div>

@pushOnce('script')
    <script src="{{ asset('js/views/components/inputs/dropdown.js') }}"></script>
@endPushOnce