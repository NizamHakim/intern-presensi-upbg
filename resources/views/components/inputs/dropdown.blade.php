<div x-data="{ 
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
    
    <label class="block font-medium text-sm mb-1.5 text-gray-600">{{ $label }}</label>
    <button x-on:click="(!showDropdown) ? openDropdown() : closeDropdown()" 
        type="button" 
        class="w-full px-3 py-2 flex flex-row justify-between items-center rounded-md bg-gray-200 outline outline-1.5 outline-offset-0 transition-all hover:bg-gray-300"
        :class="(showDropdown) ? 'outline-upbg-light' : 'outline-transparent'">
        <span x-text="selected.text" :class="selected.value ? 'text-gray-600' : 'text-gray-400'" class="font-medium truncate"></span>
        <i :class="showDropdown ? 'rotate-180' : ''" class="fa-solid fa-chevron-down text-xs transition"></i>
    </button>

    <input type="hidden" name="{{ $inputName }}" :value="selected.value">

    <ul x-show="showDropdown" 
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
</div>