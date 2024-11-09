<div x-data="{ selected: @js($selected), options: @js($options) }" {{ $attributes->merge(['class' => 'flex-1 flex flex-row rounded-md']) }}>
    <div x-data="{ 
            showDropdown: false, 
            openDropdown() {
                this.showDropdown = true;
            },
            closeDropdown() {
                this.showDropdown = false;
            }
        }" 
        x-init="console.log(options);"
        x-on:click.outside="closeDropdown()"
        class="relative w-32">
        
        <button x-on:click="(!showDropdown) ? openDropdown() : closeDropdown()" 
            type="button" 
            class="peer-focus:focus:outline-upbg-light w-full px-3 h-10 flex flex-row justify-between items-center rounded-l-md bg-upbg text-white outline-1.5 outline-offset-0 transition-all hover:bg-upbg-dark">
            <span x-text="selected.text" class="font-medium truncate"></span>
            <i :class="showDropdown ? 'rotate-180' : ''" class="fa-solid fa-chevron-down text-xs transition"></i>
        </button>
    
        <ul x-cloak 
            x-show="showDropdown" 
            x-transition:enter="transition ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute -bottom-1 translate-y-full w-full bg-white transition shadow-strong border rounded-md z-10 max-h-52 overflow-auto">

            <template x-for="(option, index) in options" :key="index">
                <li x-on:click="selected = option; closeDropdown()" 
                    :class="[(selected.value == option.value) ? 'border-upbg' : 'border-transparent', index == options.length - 1 ? 'rounded-b-md' : '']" 
                    class="px-2 py-2 cursor-pointer hover:bg-gray-200 border-l-4 truncate" x-text="option.text"></li>
            </template>
        </ul>
    </div>
    <input type="search" :name="selected.value" placeholder="{{ $placeholder }}" value="{{ $value }}" class="peer flex-1 px-3 h-10 rounded-r-md border-y border-r border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
</div>