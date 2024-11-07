<x-layouts.user-layout>
    <x-slot:title>Daftar Kelas</x-slot>
    <h1 class="font-semibold text-upbg text-3xl">Daftar Kelas</h1>
    
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
                <x-inputs.number :value="$banyakPertemuan" placeholder="Semua" label="Banyak Pertemuan" inputName="banyak-pertemuan" class="filter-field"/>
                <x-inputs.date :value="$tanggalMulai" placeholder="Semua" label="Tanggal Mulai" inputName="tanggal-mulai" class="filter-field"/>
                <x-inputs.dropdown :options="$ruanganOptions" :selected="$ruanganSelected" label="Ruangan" inputName="ruangan" class="filter-field"/>
                <x-inputs.dropdown :options="$statusOptions" :selected="$statusSelected" label="Status" inputName="status" class="filter-field"/>
                <x-inputs.dropdown :options="$sortByOptions" :selected="$sortBySelected" label="Sort By" inputName="sort-by" class="filter-field"/>
                <div class="lg:col-span-2">
                    <x-inputs.dropdown :options="$pengajarOptions" :selected="$pengajarSelected" label="Pengajar" inputName="pengajar" class="filter-field"/>
                </div>

                <button type="button" class="reset-filter w-full h-fit self-end border bg-white border-red-400 text-red-400 transition duration-300 hover:bg-red-400 hover:text-white font-medium px-3 py-2 rounded-md lg:col-start-3 lg:col-end-4 xl:col-start-4 xl:col-end-5">
                    <span>Reset filter</span>
                </button>
            </div>
        </form>
    </div>

    {{-- kelaslist desktop --}}
    <table class="w-full table-fixed hidden lg:table mt-8 shadow-strong">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-3 py-4 xl:w-108 font-semibold tracking-wide text-left">Kode Kelas</th>
                <th class="px-3 py-4 xl:w-72 font-semibold tracking-wide text-left">Jadwal</th>
                <th class="px-3 py-4 xl:w-48 font-semibold tracking-wide text-left">Ruangan</th>
                <th class="hidden xl:table-cell px-3 py-4 font-semibold tracking-wide text-left">Progress</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @if ($kelasList->isEmpty())
                <tr>
                    <td class="px-3 py-4 text-center font-medium text-gray-400" colspan="4">Tidak ada kelas yang cocok</td>
                </tr>
            @else
                @foreach ($kelasList as $kelas)
                    <tr class="bg-white transition hover:bg-gray-100">
                        <td class="px-3 py-4 xl:w-108">
                            <a href="#" class="text-upbg underline decoration-transparent transition hover:decoration-upbg font-semibold">{{ $kelas->kode }}</a>
                        </td>
                        <td class="px-3 py-4 xl:w-72">
                            <div class="flex flex-col gap-2">
                                @foreach ($kelas->jadwal as $jadwal)
                                    <div class="flex flex-row gap-1">
                                        <span class="text-base w-24"><i class="fa-solid fa-calendar-days mr-2"></i>{{ $jadwal->namaHari }}</span>
                                        <span class="text-base"><i class="fa-regular fa-clock mr-2"></i>{{ $jadwal->waktu_mulai->format('H:i') }} - {{ $jadwal->waktu_selesai->format('H:i') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-3 py-4 xl:w-48">
                            <span class="text-base"><i class="fa-regular fa-building mr-2"></i>{{ $kelas->ruangan->kode }}</span>
                        </td>
                        <td class="px-3 py-4 hidden xl:table-cell">
                            <div class="flex flex-col gap-1 items-end justify-center">
                                <span class="text-sm font-medium">{{ $kelas->progress . "/" . $kelas->banyak_pertemuan }} Pertemuan</span>
                                <div class="w-full h-2 border border-gray-400 rounded-xl">
                                    <div data-progress="{{ $kelas->progress }}" data-banyak-pertemuan="{{ $kelas->banyak_pertemuan }}" class="progress-bar h-full @if($kelas->progress == $kelas->banyak_pertemuan) bg-green-600 @else bg-upbg @endif"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="mb-10">
        {{ $kelasList->onEachSide(2)->links() }}
    </div>

    @push('script')
        <script src="{{ asset('js/views/kelas/daftar-kelas.js') }}"></script>
    @endpush
</x-layouts.user-layout>