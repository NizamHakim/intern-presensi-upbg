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
        <h1 class="font-bold text-upbg text-3xl">Tambah Peserta</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <div class="flex flex-col bg-white p-6 shadow-sm">
        <section id="input-excel-csv" class="flex flex-col gap-6">
            <div class="flex flex-row items-center gap-6">
                <label id="excel-csv-label" for="excel-csv" class="button-style w-fit text-gray-700 cursor-pointer hover:bg-gray-100"><i class="fa-solid fa-file mr-2"></i>Pilih file</label>
                <input id="excel-csv" name="input-excel-csv" type="file" class="hidden" accept=".xlsx,.csv">
                <div class="panduan-penggunaan flex flex-row items-center gap-2 text-gray-700 cursor-pointer transition hover:text-upbg">
                    <i class="fa-solid fa-circle-info text-base"></i>
                    <span class="text-xs">Panduan penggunaan</span>
                </div>
            </div>
            <div class="file-upload-progress hidden">
            </div>
        </section>

        <hr class="my-5">
        
        <form action="{{ route('kelas.storePeserta', ['slug' => $kelas->slug]) }}" method="POST" class="tambah-peserta-form">
            @csrf
            <section id="form-section" class="flex flex-col gap-2">
                <h1 class="text-gray-700 font-medium">Peserta</h1>
                <div class="peserta-container flex flex-col gap-3">
                    <div class="peserta-item-placeholder flex flex-col justify-center items-center text-gray-400 h-14 border border-dashed border-gray-400 rounded-md">
                        Tambah peserta
                    </div>
                </div>
                <div class="flex flex-row items-center gap-4 mt-1">
                    <hr class="flex-1">
                    <button type="button" class="tambah-peserta font-medium text-gray-600 size-10 border rounded-full text-lg transition hover:text-white hover:bg-green-600 hover:border-green-600"><i class="fa-solid fa-plus"></i></button>
                    <hr class="flex-1">
                </div>
            </section>
    
            <hr class="my-5">
            
            <div class="flex flex-row gap-2 justify-end">
                <a href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</a>
                <button type="submit" class="submit-button button-style button-green-solid">Tambah</button>
            </div>
        </form>
    </div>


    <x-ui.modal id="add-edit-peserta-modal">
        <form class="flex flex-col gap-4">
            <div class="input-group flex flex-col gap-1">
                <label class="font-medium text-gray-700">NIK / NRP :</label>
                <input type="text" name="nik-peserta" placeholder="NIK / NRP" class="input-style autofill:bg-white" required>
            </div>
            <div class="input-group flex flex-col gap-1">
                <label class="font-medium text-gray-700">Nama :</label>
                <input type="text" name="nama-peserta" placeholder="Nama" class="input-style" required>
            </div>
            <div class="input-group flex flex-col gap-1">
                <label class="font-medium text-gray-700">Departemen / Occupation :</label>
                <input type="text" name="occupation-peserta" placeholder="Departemen / Occupation" class="input-style" required>
            </div>
            <div class="flex flex-row justify-end gap-4">
                <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                <button type="submit" class="submit-button button-style">Tambah</button>
            </div>
        </form>
    </x-ui.modal>

    @pushOnce('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/tambah-peserta.js') }}"></script>
    @endPushOnce
</x-layouts.user-layout>