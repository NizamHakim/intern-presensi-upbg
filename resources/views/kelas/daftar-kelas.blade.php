<x-layouts.user-layout>
    <x-slot:title>Daftar Kelas</x-slot>
    <h1 class="font-semibold text-upbg text-3xl">Daftar Kelas</h1>

    {{-- filter mobile --}}
    {{-- <div x-data="{showFilter: false}" class="mt-4 lg:hidden">
        <form x-data="{ searchCode: '' }" action="{{ route('admin.kelas') }}" method="GET" class="flex flex-col gap-4">
            <div class="flex flex-row gap-2">
                <input x-model="searchCode" type="search" name="searchCode" placeholder="Cari Kode Kelas" class="flex-1 px-3 py-2 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline-none">
                <button type="submit" class="bg-upbg transition duration-300 hover:bg-upbg-dark text-white px-3 py-2 rounded-md">
                    <span><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</span>
                </button>
            </div>
            <button type="button" x-on:click="showFilter = true" class="w-24 flex flex-row justify-center items-center bg-gray-200 gap-2 py-2 rounded-md transition duration-300 hover:bg-gray-300">
                <span class="font-medium">Filter</span>
                <i :class="showFilter ? 'rotate-180' : ''" class="fa-solid fa-chevron-right text-xs align-middle transition duration-700"></i>
            </button>
    
            <div x-show="showFilter" 
                x-transition:enter="transition-transform ease-out"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition-transform ease-in"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed flex flex-col bg-white inset-0 transition-transform px-4 py-2 overflow-y-auto z-50">
    
                <div class="h-14 w-full flex flex-row justify-between items-center">
                    <h1 class="font-medium text-2xl text-gray-600">Filter</h1>
                    <button x-on:click="showFilter = false" type="button" class="flex flex-row justify-center items-center text-2xl text-gray-600 rounded-full size-10 transition hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></i></button>
                </div>
    
                <div class="flex flex-col my-8 gap-4">
                    <x-dropdown :options="$programList" :defaultOption="['text' => 'Semua', 'value' => '']"  inputName="programFilter" label="Program"/>
                    <x-dropdown :options="$tipeList" :defaultOption="['text' => 'Semua', 'value' => '']" inputName="tipeFilter" label="Tipe"/>
                    <x-input-number name="numberFilter" label="Nomor Kelas" placeholder="Semua"/>    
                    <x-dropdown :options="$levelList" :defaultOption="['text' => 'Semua', 'value' => '']" inputName="levelFilter" label="Level"/>
                    <x-input-number name="meetingsTotalFilter" label="Banyak Pertemuan" placeholder="Semua"/>    
                    <x-input-date name="startingDateFilter" label="Tanggal Mulai" placeholder="Semua"/>
                    <x-dropdown :options="$ruanganList" :defaultOption="['text' => 'Semua', 'value' => '']" inputName="ruanganFilter" label="Ruangan"/>
                    <x-dropdown :options="$statusList" :defaultOption="['text' => 'Semua', 'value' => '']" inputName="statusFilter" label="Status"/>
                    <x-dropdown :options="$sortByList" :defaultOption="$sortByList[0]" inputName="sortByFilter" label="Sort By"/>
                    <hr class="border-gray-200">
                    <div class="flex flex-col w-full">
                        <label class="block font-medium text-sm mb-1.5 text-gray-600">Cari Kode Kelas</label>
                        <input x-model="searchCode" type="search" class="w-full px-3 py-2 rounded-md bg-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline-none" name="searchCode" placeholder="Cari Kode Kelas">
                    </div>
                    <hr class="border-gray-200">
                    <button type="submit" class="bg-upbg transition duration-300 hover:bg-upbg-dark text-white font-medium px-3 py-2 rounded-md">
                        <i class="fa-solid fa-search"></i>
                        <span>Search</span>
                    </button>
                    <button type="button" class="border bg-white border-red-400 text-red-400 transition duration-300 hover:bg-red-400 hover:text-white font-medium px-3 py-2 rounded-md">
                        <span>Reset filter</span>
                    </button>
                </div>
            </div>
        </form>
    </div> --}}
    
    {{-- filter desktop --}}
    <div x-data="{showFilter: false}" class="mt-4 hidden lg:block">
        <form x-data="{ search: '' }" action="{{ route('kelas.index') }}" method="GET" class="flex flex-col gap-4">
            <div class="flex flex-row gap-2">
                <button type="button" x-on:click="showFilter = !showFilter" class="w-24 flex flex-row justify-center items-center bg-gray-200 gap-2 py-2 rounded-md transition duration-300 hover:bg-gray-300">
                    <span class="font-medium">Filter</span>
                    <i :class="showFilter ? 'rotate-180' : ''" class="fa-solid fa-chevron-down text-xs align-middle transition duration-300"></i>
                </button>
                <input x-model="search" type="search" name="search" placeholder="Cari Kode Kelas" class="flex-1 px-3 py-2 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline-none">
                <button type="submit" class="bg-upbg transition duration-300 hover:bg-upbg-dark text-white px-3 py-2 rounded-md">
                    <span><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</span>
                </button>
            </div>
    
            <div x-cloak x-show="showFilter" 
                x-transition:enter="transition-all ease-out overflow-hidden"
                x-transition:enter-start="max-h-0"
                x-transition:enter-end="max-h-80"
                x-transition:leave="transition-all ease-in overflow-hidden"
                x-transition:leave-start="max-h-80"
                x-transition:leave-end="max-h-0"
                class="grid lg:grid-cols-3 xl:grid-cols-4 gap-4 transition-all">
    
                <x-inputs.dropdown :options="$programOptions" :selected="$programSelected" label="Program" inputName="program" class="filter-field"/>
                <x-inputs.dropdown :options="$tipeOptions" :selected="$tipeSelected" label="Tipe" inputName="tipe" class="filter-field"/>
                <x-inputs.number :value="$nomor" placeholder="Semua" label="Nomor" inputName="nomor" class="filter-field"/>
                <x-inputs.dropdown :options="$levelOptions" :selected="$levelSelected" label="Level" inputName="level" class="filter-field"/>
                <x-inputs.number :value="$banyakPertemuan" placeholder="Semua" label="Banyak Pertemuan" inputName="banyakPertemuan" class="filter-field"/>
                <x-inputs.date :value="$tanggalMulai" placeholder="Semua" label="Tanggal Mulai" inputName="tanggalMulai" class="filter-field"/>
                <x-inputs.dropdown :options="$ruanganOptions" :selected="$ruanganSelected" label="Ruangan" inputName="ruangan" class="filter-field"/>
                <x-inputs.dropdown :options="$statusOptions" :selected="$statusSelected" label="Status" inputName="status" class="filter-field"/>
                <x-inputs.dropdown :options="$sortByOptions" :selected="$sortBySelected" label="Sort By" inputName="sortBy" class="filter-field"/>

                <button type="button" class="reset-filter w-full h-fit self-end border bg-white border-red-400 text-red-400 transition duration-300 hover:bg-red-400 hover:text-white font-medium px-3 py-2 rounded-md lg:col-start-3 lg:col-end-4 xl:col-start-4 xl:col-end-5">
                    <span>Reset filter</span>
                </button>
            </div>
        </form>
    </div>
    @push('script')
        <script src="{{ asset('js/views/kelas/daftar-kelas.js') }}"></script>
    @endpush
</x-layouts.user-layout>