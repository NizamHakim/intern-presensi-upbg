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
        <h1 class="page-title">Daftar Peserta</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <section id="daftar-peserta" class="flex flex-col">
        @if (auth()->user()->current_role_id == 2)
            <div class="flex flex-row justify-end mb-4">
                <a href="{{ route('kelas.tambahPeserta', ['slug' => $kelas->slug]) }}" class="button-style button-green-solid"><i class="fa-solid fa-plus mr-1"></i>Tambah Peserta</a>
            </div>
        @endif
        <div class="peserta-container flex flex-col bg-white divide-y shadow-sm">
            <div class="peserta-header py-2 flex flex-row items-center sm:py-4">
                <p class="w-12 text-gray-600 font-semibold tracking-wide text-center sm:w-20 sm:px-6">No.</p>
                <p class="flex-1 px-2 text-gray-600 font-semibold tracking-wide text-left">Peserta</p>
                <p class="hidden flex-1 text-gray-600 font-semibold tracking-wide text-left md:block md:max-w-36 md:px-6 xl:max-w-52">Tanggal Bergabung</p>
                <p class="hidden flex-1 text-gray-600 font-semibold tracking-wide text-center md:block md:px-4">Status</p>
                @if (auth()->user()->current_role_id == 2)
                    <div class="w-20 sm:w-24 sm:pr-6 md:w-28"></div>
                @endif
            </div>
            @foreach ($pesertaList as $peserta)
                <div class="peserta-item flex flex-row items-center border-t py-5" data-peserta-id="{{ $peserta->id }}">
                    <p class="w-12 text-center font-medium sm:w-20 sm:px-6">{{ $loop->iteration + ($pesertaList->currentPage() - 1) * $pesertaList->perPage() }}.</p>
                    <div class="flex-1 px-2 flex flex-col">
                        <p class="nama-peserta w-fit font-medium text-gray-700">{{ $peserta->nama }}</p>
                        <p class="nik-peserta w-fit text-gray-600">{{ $peserta->nik }}</p>
                    </div>
                    <div class="hidden flex-1 md:block md:max-w-36 md:px-6 xl:max-w-52">
                        <p class="tanggal-bergabung-peserta text-gray-600">{{ $peserta->created_at->format('d-m-Y') }}</p>
                    </div>
                    <div class="hidden flex-1 flex-row justify-center md:flex md:px-4">
                        @if ($peserta->pivot->aktif)
                            <p class="aktif-peserta bg-green-300 text-green-800 text-sm font-semibold px-2 rounded-full">Aktif</p>
                        @else
                            <p class="aktif-peserta bg-red-300 text-red-800 text-sm font-semibold px-2 rounded-full">Tidak Aktif</p>
                        @endif
                    </div>
                    @if (auth()->user()->current_role_id == 2)
                        <div class="buttons-container flex flex-col gap-2 w-20 pr-2 sm:w-24 sm:pr-6 md:w-28">
                            <button type="button" class="detail-peserta button-style button-upbg-solid md:hidden">Detail</button>
                            <button type="button" class="edit-peserta hidden select-none px-4 py-1.5 rounded-sm-md border font-medium transition text-xs bg-white text-upbg border-upbg hover:text-white hover:bg-upbg md:flow-root">Edit</button>
                            <button type="button" class="delete-peserta hidden select-none px-4 py-1.5 rounded-sm-md border font-medium transition text-xs bg-white text-red-600 border-red-600 hover:text-white hover:bg-red-600 md:flow-root">Remove</button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <x-ui.modal id="detail-peserta-modal">
            <form action="{{ route('kelas.updatePeserta', ['slug' => $kelas->slug]) }}" class="flex flex-col gap-4">
                <h1 class="modal-title">Detail Peserta</h1>
                <input type="hidden" name="peserta-id">
                <hr class="w-full">
                <div class="flex flex-col gap-1">
                    <p class="text-gray-700 font-semibold">NIK / NRP</p>
                    <p class="nik-peserta">NIK / NRP Peserta</p>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-gray-700 font-semibold">Nama</p>
                    <p class="nama-peserta">Nama Peserta</p>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-gray-700 font-semibold">Tanggal Bergabung</p>
                    <p class="tanggal-bergabung-peserta">Tanggal Bergabung</p>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="text-gray-700 font-semibold">Status</p>
                    <div class="flex flex-row gap-2 items-center mb-1">
                        <x-inputs.checkbox id="aktif" type="blue" inputName="aktif" value="aktif" :checked="true"/>
                        <label for="aktif" class="label-aktif cursor-pointer">Status</label>
                    </div>
                    <div class="info-container flex flex-col gap-2">
                        <p class="font-semibold"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
                        <ul class="list-outside pl-5 list-disc space-y-1">
                            <li>Peserta yang tidak aktif tidak akan dimasukkan presensi untuk pertemuan yang akan datang</li>
                            <li>Histori presensi pertemuan peserta pada kelas ini tidak akan dihapus</li>
                        </ul>
                    </div>
                </div>
                <hr class="w-full">
                <div class="flex flex-row justify-between items-center md:justify-end">
                    <button type="button" class="delete-peserta button-style button-red-outline md:hidden">Remove</button>
                    <div class="flex flex-row gap-4">
                        <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                        <button type="submit" class="submit-button button-style button-green-solid">Simpan</button>
                    </div>
                </div>
            </form>
        </x-ui.modal>
        <x-ui.modal id="delete-peserta-modal">
            <form action="{{ route('kelas.destroyPeserta', ['slug' => $kelas->slug]) }}" class="flex flex-col gap-4">
                <h1 class="modal-title">Hapus Peserta</h1>
                <hr class="w-full">
                <input type="hidden" name="peserta-id">
                <p>Apakah anda yakin ingin menghapus <span class="font-bold nama-nik-peserta">Peserta</span> dari kelas ini?</p>
                <div class="danger-container flex flex-col gap-2">
                    <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
                    <p>Data pertemuan peserta pada kelas ini akan dihapus permanen</p>
                </div>
                <hr class="w-full">
                <div class="flex flex-row gap-4 justify-end items-center">
                    <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                    <button type="submit" class="submit-button button-style button-red-solid">Remove</button>
                </div>
            </form>
        </x-ui.modal>
    </section>
    

    <section>
        {{ $pesertaList->onEachSide(2)->links() }}
    </section>

    @pushOnce('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/detail-daftar-peserta.js') }}"></script>
    @endPushOnce
</x-layouts.user-layout>