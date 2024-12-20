<x-layouts.user-layout>
    <x-slot:title>Daftar Kelas</x-slot>
    <div class="flex flex-row gap-2 justify-between items-center mt-6 mb-8">
        <h1 class="page-title">Daftar Kelas</h1>
        <a href="{{ route('kelas.create') }}" class="button-style text-center button-green-solid"><i class="fa-solid fa-plus mr-1"></i>Tambah Kelas</a>
    </div>

    <section id="filter-kelas" class="mb-4">
        <form action="{{ route('kelas.index') }}" method="GET" class="filter-form flex flex-col gap-2">
            <div class="flex flex-row gap-2">
                <button type="button" class="open-filter hidden px-4 py-2 bg-white rounded-sm-md shadow-sm font-medium transition text-xs sm:flow-root md:text-sm">Filter<i class="fa-solid fa-chevron-down transition-transform text-xs ml-2"></i></button>
                <input type="search" name="kode" value="{{ $selected['kode'] }}" placeholder="Cari kode kelas" class="flex-1 shadow-sm px-2 py-2 rounded-sm-md outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
                <button type="submit" class="filter-close-submit button-style button-upbg-solid shadow-sm"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
            </div>
            <button type="button" class="open-filter-mobile shadow-sm bg-white px-4 py-2 rounded-sm-md font-medium transition text-xs sm:hidden">Filter<i class="fa-solid fa-chevron-right text-xs ml-1"></i></button>
            
            <div class="filter-container fixed inset-0 bg-white flex flex-col px-4 pt-4 pb-28 overflow-y-scroll z-[100] -translate-x-full transition-all sm:static sm:translate-x-0 sm:overflow-hidden sm:py-0 sm:z-0 sm:max-h-0">
                <div class="flex flex-row justify-between items-center text-xl font-semibold text-gray-700 mb-8 sm:hidden">
                    <p>Filter Kelas</p>
                    <button type="button" class="close-filter rounded-full bg-white size-9 transition hover:bg-gray-200"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-4 lg:grid-cols-3 xl:grid-cols-4">
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Program Kelas</p>
                        <x-inputs.dropdown.select name="program" placeholder="Semua" class="program-dropdown filter-field" :selected="($selected['program']) ? ['text' => $selected['program']->nama . ' (' . $selected['program']->kode . ')', 'value' => $selected['program']->id] : null">
                            @foreach ($programOptions as $program)
                                <x-inputs.dropdown.option :value="$program->id" class="{{ ($selected['program'] && $selected['program']->id == $program->id) ? 'selected' : '' }}">{{ "$program->nama ($program->kode)" }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Tipe Kelas</p>
                        <x-inputs.dropdown.select name="tipe" placeholder="Semua" class="tipe-dropdown filter-field" :selected="($selected['tipe']) ? ['text' => $selected['tipe']->nama . ' (' . $selected['tipe']->kode . ')', 'value' => $selected['tipe']->id] : null">
                            @foreach ($tipeOptions as $tipe)
                                <x-inputs.dropdown.option :value="$tipe->id" class="{{ ($selected['tipe'] && $selected['tipe']->id == $tipe->id) ? 'selected' : '' }}">{{ "$tipe->nama ($tipe->kode)" }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Nomor Kelas</p>
                        <input type="number" name="nomor" value="{{ $selected['nomor'] }}" class="input-style input-number filter-field" placeholder="Semua">
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Level Kelas</p>
                        <x-inputs.dropdown.select name="level" placeholder="Semua" class="level-dropdown filter-field" :selected="($selected['level']) ? ['text' => $selected['level']->nama . ' (' . $selected['level']->kode . ')', 'value' => $selected['level']->id] : null">
                            @foreach ($levelOptions as $level)
                                <x-inputs.dropdown.option :value="$level->id" class="{{ ($selected['level'] && $selected['level']->id == $level->id) ? 'selected' : '' }}">{{ "$level->nama ($level->kode)" }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Banyak Pertemuan</p>
                        <input type="number" name="banyak-pertemuan" value="{{ $selected['banyak-pertemuan'] }}" class="input-style input-number filter-field" placeholder="Semua">
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Tanggal Mulai</p>
                        <x-inputs.date inputName="tanggal-mulai" class="filter-field" value="{{ $selected['tanggal-mulai'] }}" placeholder="Semua" plugin="month"/>
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Ruangan</p>
                        <x-inputs.dropdown.select name="ruangan" placeholder="Semua" class="ruangan-dropdown filter-field" :selected="($selected['ruangan']) ? ['text' => $selected['ruangan']->kode, 'value' => $selected['ruangan']->id] : null">
                            @foreach ($ruanganOptions as $ruangan)
                                <x-inputs.dropdown.option :value="$ruangan->id" class="{{ ($selected['ruangan'] && $selected['ruangan']->id == $ruangan->id) ? 'selected' : '' }}">{{ $ruangan->kode }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Status</p>
                        <x-inputs.dropdown.select name="status" placeholder="Semua" class="status-dropdown filter-field" :selected="($selected['status']) ? ['text' => $selected['status']['text'], 'value' => $selected['status']['value']] : null">
                            @foreach ($statusOptions as $status)
                                <x-inputs.dropdown.option value="{{ $status['value'] }}" class="{{ ($selected['status'] && $selected['status']['value'] == $status['value']) ? 'selected' : '' }}">{{ $status['text'] }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Sort By</p>
                        <x-inputs.dropdown.select name="order" placeholder="None" class="sort-dropdown filter-field" :selected="($selected['sortby']) ? ['text' => $selected['sortby']['text'], 'value' => $selected['sortby']['value']] : null">
                            @foreach ($sortbyOptions as $sortby)
                                <x-inputs.dropdown.option value="{{ $sortby['value'] }}" class="{{ ($selected['sortby'] && $selected['sortby']['value'] == $sortby['value']) ? 'selected' : '' }}">{{ $sortby['text'] }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                    </div>
                    <div class="input-group">
                        <p class="text-gray-600 font-medium mb-1">Pengajar</p>
                        <x-inputs.dropdown.select name="pengajar" placeholder="Semua" class="pengajar-dropdown filter-field" :selected="($selected['pengajar']) ? ['text' => $selected['pengajar']->nama . ' (' . $selected['pengajar']->nik . ' )', 'value' => $selected['pengajar']->id] : null">
                            @foreach ($pengajarOptions as $pengajar)
                                <x-inputs.dropdown.option :value="$pengajar->id" class="{{ ($selected['pengajar'] && $selected['pengajar']->id == $pengajar->id) ? 'selected' : '' }}">{{ "$pengajar->nama ($pengajar->nik)" }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                    </div>
                    <hr class="sm:hidden">
                    <div class="input-group sm:hidden">
                        <p class="text-gray-600 font-medium mb-1">Kode Kelas</p>
                        <input type="search" name="kode" value="{{ $selected['kode'] }}" placeholder="Cari kode kelas" class="input-style w-full">
                    </div>
                    <button type="submit" class="px-4 py-2 self-end border rounded-sm-md button-upbg-solid sm:row-start-6 sm:row-span-1 sm:col-start-2 sm:col-span-1 lg:row-start-4 lg:row-span-1 lg:col-start-3 lg:col-span-1 xl:row-start-3 xl:row-span-1 xl:col-start-4 xl:col-span-1"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
                    <button type="button" class="reset-filter self-end font-medium px-4 py-2 border rounded-sm-md border-red-600 text-red-600 bg-white transition hover:bg-red-600 hover:text-white sm:row-start-6 sm:row-span-1 sm:col-start-1 sm:col-span-1 lg:row-start-4 lg:row-span-1 lg:col-start-2 lg:col-span-1 xl:row-start-3 xl:row-span-1 xl:col-start-3 xl:col-span-1">Reset Filter</button>
                </div>
            </div>
        </form>
    </section>

    <section id="daftar-kelas" class="flex flex-col lg:divide-y">
        <div class="hidden bg-white p-4 lg:grid lg:grid-cols-6 lg:gap-x-4 xl:grid-cols-7">
            <p class="col-span-2 text-gray-600 font-semibold tracking-wide">Kode Kelas</p>
            <p class="col-span-2 text-gray-600 font-semibold tracking-wide">Jadwal</p>
            <p class="col-span-1 text-gray-600 font-semibold tracking-wide">Ruangan</p>
            <p class="col-span-1 text-gray-600 font-semibold tracking-wide xl:col-span-2">Progress</p>
        </div>
        <div class="kelas-container flex flex-col gap-3 lg:gap-0 lg:divide-y">
            @foreach ($kelasList as $kelas)
                <div class="kelas-item grid grid-cols-1 gap-y-3 bg-white p-4 shadow-sm rounded-sm-md lg:grid-cols-6 lg:gap-y-0 lg:rounded-none lg:gap-x-4 xl:grid-cols-7">
                    <div class="flex flex-row items-center lg:col-span-2">
                        <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="font-semibold text-upbg truncate underline decoration-transparent transition hover:decoration-upbg">{{ $kelas->kode }}</a>
                    </div>
                    <div class="flex flex-col justify-center lg:col-span-2">
                        <div class="flex flex-col gap-2 text-gray-700">
                            @foreach ($kelas->jadwal as $jadwal)
                                <p><i class="fa-solid fa-calendar-days mr-2"></i><span class="mr-2">{{ $jadwal->namaHari }}</span><i class="fa-regular fa-clock mr-2"></i><span>{{ $jadwal->waktu_mulai->format('H:i') }} - {{ $jadwal->waktu_selesai->format('H:i') }}</span></p>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col justify-center lg:col-span-1">
                        <p class="text-gray-700"><i class="fa-regular fa-building mr-2"></i>{{ $kelas->ruangan->kode }}</p>
                    </div>
                    <div class="flex flex-col gap-1 items-end justify-center lg:col-span-1 xl:col-span-2">
                        <span class="text-gray-700 font-medium">{{ $kelas->progress . "/" . $kelas->banyak_pertemuan }} Pertemuan</span>
                        <div class="w-full h-1.5 border rounded bg-slate-200 shadow-inner">
                            @php
                                $progress = ($kelas->progress / $kelas->banyak_pertemuan)*100;
                                $bgcolor = $progress == 100 ? 'bg-green-600' : 'bg-upbg';
                            @endphp
                            <div style="width: {{ $progress }}%" class="{{ $bgcolor }} h-full rounded-full"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section>
        {{ $kelasList->onEachSide(2)->links() }}
    </section>

    @push('script')
        <script src="{{ asset('js/views/kelas/daftar-kelas.js') }}"></script>
    @endpush
</x-layouts.user-layout>