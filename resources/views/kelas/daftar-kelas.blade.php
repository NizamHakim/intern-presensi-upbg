<x-layouts.user-layout>
    <x-slot:title>Daftar Kelas</x-slot>
    <div class="flex flex-row justify-between items-center gap-4 mt-6 mb-6">
        <h1 class="font-bold text-upbg text-[2rem]">Daftar Kelas</h1>
        <a href="#" class="bg-green-600 shadow-sm transition duration-300 hover:bg-green-700 text-sm px-4 py-2 font-medium text-white rounded-sm-md"">
            <i class="fa-solid fa-plus mr-1"></i>
            <span>Tambah Kelas</span>
        </a>
    </div>
    
    {{-- filter desktop --}}
    <div class="hidden lg:block">
        <form action="{{ route('kelas.index') }}" method="GET" class="flex flex-col gap-4">
            <div class="flex flex-row gap-2">
                <button type="button" class="w-24 border flex flex-row justify-center items-center bg-white gap-2 py-2 rounded-sm-md transition duration-300">
                    <span class="font-medium">Filter</span>
                    <i class="fa-solid fa-chevron-down text-xs align-middle transition duration-300"></i>
                </button>
                <input type="search" name="search" placeholder="Cari Kode Kelas" class="flex-1 px-3 py-2 rounded-sm-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
                <button type="submit" class="bg-upbg transition duration-300 hover:bg-upbg-dark text-white px-3 py-2 rounded-sm-md">
                    <span><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</span>
                </button>
            </div>
    
            <div class="grid lg:grid-cols-3 xl:grid-cols-4 gap-4 transition-all duration-300">
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
    <table class="w-full table-fixed hidden lg:table mt-10 shadow-sm">
        <thead class="bg-white border-b">
            <tr>
                <th class="px-3 py-4 xl:w-96 text-gray-600 font-semibold tracking-wide text-left">Kode Kelas</th>
                <th class="px-3 py-4 xl:w-72 text-gray-600 font-semibold tracking-wide text-left">Jadwal</th>
                <th class="px-3 py-4 xl:w-40 text-gray-600 font-semibold tracking-wide text-left">Ruangan</th>
                <th class="hidden xl:table-cell px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Progress</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @if ($kelasList->isEmpty())
                <tr>
                    <td class="px-3 py-4 text-center font-medium text-gray-400" colspan="4">Tidak ada kelas yang cocok</td>
                </tr>
            @else
                @foreach ($kelasList as $kelas)
                    <tr class="bg-white">
                        <td class="px-3 py-4 xl:w-96">
                            <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="text-upbg underline decoration-transparent transition hover:decoration-upbg font-medium">{{ $kelas->kode }}</a>
                        </td>
                        <td class="px-3 py-4 xl:w-72">
                            <div class="flex flex-col gap-3">
                                @foreach ($kelas->jadwal as $jadwal)
                                    <div class="flex flex-row gap-1">
                                        <span class="text-sm w-24 text-gray-800"><i class="fa-solid fa-calendar-days mr-2"></i>{{ $jadwal->namaHari }}</span>
                                        <span class="text-sm text-gray-800"><i class="fa-regular fa-clock mr-2"></i>{{ $jadwal->waktu_mulai->format('H:i') }} - {{ $jadwal->waktu_selesai->format('H:i') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-3 py-4 xl:w-40">
                            <span class="text-sm text-gray-800"><i class="fa-regular fa-building mr-2"></i>{{ $kelas->ruangan->kode }}</span>
                        </td>
                        <td class="px-3 py-4 hidden xl:table-cell">
                            <div class="flex flex-col gap-1 items-end justify-center">
                                <span class="text-sm font-normal text-gray-800">{{ $kelas->progress . "/" . $kelas->banyak_pertemuan }} Pertemuan</span>
                                <div class="w-full h-1.5 border border-gray-400 rounded-xl bg-slate-200 shadow-inner">
                                    <div data-progress="{{ $kelas->progress }}" data-banyak-pertemuan="{{ $kelas->banyak_pertemuan }}" class="progress-bar h-full @if($kelas->progress == $kelas->banyak_pertemuan) bg-green-600 @else bg-upbg-dark @endif"></div>
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