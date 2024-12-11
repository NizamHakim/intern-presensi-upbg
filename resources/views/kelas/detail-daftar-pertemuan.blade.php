<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>{{ $kelas->kode }}</x-slot>
    <x-slot:sidenav>
        <x-layouts.navgroup title="{{ $kelas->kode }}">
            <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
            <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
        </x-layouts.navgroup>
        <hr>
    </x-slot>

    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-3xl">Detail Kelas</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <section id="detail-kelas" class="flex flex-col gap-6 bg-white shadow-sm mt-6 p-6 md:flex-row md:justify-between">
        <div class="flex flex-col gap-6">
            <h2 class="text-gray-700 font-semibold text-xl md:text-2xl">{{ $kelas->kode }}</h2>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-1">Pengajar:</h3>
                <ul class="list-none">
                    @foreach ($kelas->pengajar as $pengajar)
                        <li><a href="{{ route('user.detail', ['id' => $pengajar->id]) }}" class="underline decoration-transparent text-gray-700 transition hover:text-upbg hover:decoration-upbg">{{ $pengajar->nama }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-2">Jadwal:</h3>
                <div class="flex flex-col gap-2 text-gray-700">
                    @foreach ($kelas->jadwal as $jadwal)
                        <p><i class="fa-solid fa-calendar-days mr-2"></i><span class="mr-2">{{ $jadwal->namaHari }}</span><i class="fa-regular fa-clock mr-2"></i><span>{{ $jadwal->waktu_mulai->format('H:i') }} - {{ $jadwal->waktu_selesai->format('H:i') }}</span></p>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-1">Ruangan:</h3>
                <span class="text-gray-700"><i class="fa-regular fa-building mr-2"></i>{{ $kelas->ruangan->kode }}</span>
            </div>
        </div>
        <div class="flex flex-col gap-2 h-fit md:flex-row">
            <a href="{{ route('kelas.edit', ['slug' => $kelas->slug]) }}" class="button-style text-center border-upbg text-upbg hover:bg-upbg hover:text-white"><i class="fa-regular fa-pen-to-square mr-1"></i>Edit</a>
            <button type="button" class="delete-kelas button-style border-red-600 text-red-600 hover:bg-red-600 hover:text-white"><i class="fa-regular fa-trash-can mr-1"></i>Delete</button>
            <x-ui.delete-dialog :action="route('kelas.destroy', ['slug' => $kelas->slug])" class="delete-kelas-dialog">
                <x-slot:title>Hapus Kelas</x-slot>
                <x-slot:message>Apakah anda yakin ingin menghapus kelas <span class="font-bold">{{ $kelas->kode }}</span> ?</x-slot>
                <x-slot:deleteMessage>
                    <p class="text-red-600">Semua data untuk kelas ini akan dihapus permanen</p>
                </x-slot>
                <x-slot:hiddenInputs>
                    <input type="hidden" name="kelas-slug" value="{{ $kelas->slug }}">
                </x-slot>
            </x-ui.delete-dialog>
        </div>
    </section>

    <section id="pertemuan-terlaksana" class="flex flex-col gap-6 shadow-sm bg-white p-6 mt-6 md:flex-row md:justify-between">
        <div class="flex flex-col items-center gap-2 md:items-start">
            <p class="text-lg text-gray-700 md:text-2xl">Pertemuan Terlaksana</p>
            <p class="text-3xl text-gray-700 font-semibold md:text-4xl">{{ $kelas->progress }} / {{ $kelas->banyak_pertemuan }}</p>
        </div>
        <div class="flex flex-col gap-2 justify-center">
            <button type="button" class="tambah-pertemuan button-style border-green-600 bg-green-600 hover:bg-green-700 text-white"><i class="fa-solid fa-plus mr-1"></i><span>Tambah Pertemuan</span></button>
            <x-ui.modal id="tambah-pertemuan-modal">
                <h1 class="text-xl font-semibold text-gray-700 text-center capitalize">Tambah Pertemuan</h1>
                <hr class="bg-gray-200">
                <form action="{{ route('kelas.pertemuan.store', ['slug' => $kelas->slug]) }}" class="flex flex-col gap-4">
                    <x-inputs.date inputName="tanggal" label="Tanggal" placeholder="Pilih tanggal"/>
                    <div class="flex flex-row items-start gap-4">
                        <x-inputs.time inputName="waktu-mulai" label="Waktu mulai" placeholder="Pilih waktu mulai"/>
                        <x-inputs.time inputName="waktu-selesai" label="Waktu selesai" placeholder="Pilih waktu selesai"/>
                    </div>
                    <x-inputs.dropdown.select name="ruangan" label="Ruangan" placeholder="Pilih ruangan" :selected="['text' => $kelas->ruangan->kode, 'value' => $kelas->ruangan->id]">
                        @foreach ($ruanganOptions as $ruangan)
                            <x-inputs.dropdown.option :value="$ruangan->id" class="{{ ($ruangan->id == $kelas->ruangan->id) ? 'selected' : '' }}">{{ $ruangan->kode }}</x-inputs.dropdown.option>
                        @endforeach
                    </x-inputs.dropdown.select>
                    <hr class="bg-gray-200 w-full my-4">
                    <div class="flex flex-row justify-end gap-4">
                        <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                        <button type="submit" class="submit-button button-style border-green-600 bg-green-600 text-white hover:bg-green-700">Tambah</button>
                    </div>
                </form>
            </x-ui.modal>
        </div>
    </section>

    <section id="daftar-pertemuan" class="pertemuan-container flex flex-col shadow-sm divide-y bg-white mt-6">
        <div class="pertemuan-header py-4 hidden flex-row items-center lg:flex">
            <p class="min-w-28 max-w-36 flex-1 pl-4 text-gray-600 font-semibold tracking-wide text-center">Pertemuan ke-</p>
            <p class="min-w-60 max-w-72 flex-1 px-4 text-gray-600 font-semibold tracking-wide text-left">Jadwal</p>
            <p class="flex-1 px-4 text-gray-600 font-semibold tracking-wide text-left">Pengajar</p>
            <p class="max-w-56 flex-1 px-4 text-gray-600 font-semibold tracking-wide text-left">Status</p>
            <p class="w-32"></p>
        </div>
        @foreach ($kelas->pertemuan as $pertemuan)
            <div class="pertemuan-item flex flex-col gap-6 lg:flex-row lg:gap-0 lg:py-4">
                <div class="px-6 py-4 flex flex-row bg-upbg-dark order-1 lg:order-none lg:px-0 lg:py-0 lg:min-w-28 lg:max-w-36 lg:flex-1 lg:pl-4 lg:bg-white lg:justify-center lg:items-center">
                    <p class="font-medium text-white text-base lg:hidden">Pertemuan ke - {{ $pertemuan->pertemuan_ke }}</p>
                    <p class="font-semibold text-gray-700 text-2xl hidden lg:block">{{ $pertemuan->pertemuan_ke }}</p>
                </div>
                <div class="px-6 flex flex-col gap-2 order-3 lg:order-none lg:min-w-60 lg:max-w-72 lg:flex-1 lg:px-4">
                    <h3 class="font-semibold text-gray-700 lg:hidden">Jadwal:</h3>
                    <span class="text-gray-700"><i class="fa-solid fa-calendar-days mr-2"></i>{{ $pertemuan->tanggal->isoFormat('dddd, D MMMM YYYY')}}</span>
                    <span class="text-gray-700"><i class="fa-regular fa-clock mr-2"></i>{{ $pertemuan->waktu_mulai->isoFormat("HH:mm") . " - " . $pertemuan->waktu_selesai->isoFormat("HH:mm") }}</span>
                    <span class="text-gray-700"><i class="fa-regular fa-building mr-2"></i>{{ $pertemuan->ruangan->kode }}</span>
                </div>
                <div class="px-6 flex flex-col gap-2 order-4 lg:order-none lg:flex-1 lg:px-4 lg:justify-center">
                    <h3 class="font-semibold text-gray-700 lg:hidden">Pengajar:</h3>
                    <span class="text-gray-700">{{ ($pertemuan->pengajar_id) ? $pertemuan->pengajar->nama : '-' }}</span>
                </div>
                <div class="px-6 flex flex-col gap-2 order-2 lg:order-none lg:max-w-56 lg:flex-1 lg:px-4 lg:justify-center">
                    <h3 class="font-semibold text-gray-700 lg:hidden">Status:</h3>
                    @if ($pertemuan->terlaksana)
                        <span class="text-green-600 font-semibold">Terlaksana</span>
                    @else
                        @if (now()->isAfter($pertemuan->waktu_selesai))
                            <span class="text-red-600 font-semibold">Tidak Terlaksana</span>
                        @else
                            <span class="text-gray-700">-</span>
                        @endif
                    @endif
                </div>
                <div class="px-6 pb-6 flex flex-row order-5 lg:order-none lg:px-0 lg:pr-6 lg:pb-0 lg:w-32 lg:items-center">
                    <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="button-style flex flex-row justify-center items-center w-full text-center border-upbg text-upbg hover:bg-upbg hover:text-white">View<i class="fa-solid fa-circle-arrow-right ml-1"></i></a>
                </div>
            </div>
        @endforeach
    </section>
    
    @pushOnce('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/detail-daftar-pertemuan.js') }}"></script>        
    @endPushOnce
</x-layouts.user-layout>