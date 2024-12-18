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
        <h1 class="page-title">Tambah Peserta</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <div class="flex flex-col bg-white p-6 shadow-sm">
        <form action="{{ route('kelas.storePeserta', ['slug' => $kelas->slug]) }}" method="POST" class="tambah-peserta-form">
            @csrf
            <x-ui.file-peserta/>
    
            <hr class="my-5">
            
            <div class="flex flex-row gap-2 justify-end">
                <a href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</a>
                <button type="submit" class="submit-button button-style button-green-solid">Tambah</button>
            </div>
        </form>
    </div>

    <x-ui.add-edit-peserta-modal/>

    @pushOnce('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/tambah-peserta.js') }}"></script>
    @endPushOnce
</x-layouts.user-layout>