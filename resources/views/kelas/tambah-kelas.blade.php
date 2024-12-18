<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    <x-slot:title>Tambah Kelas</x-slot>

    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="page-title">Tambah Kelas</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <form action="{{ route('kelas.store') }}" class="edit-form flex flex-col bg-white p-6 shadow-sm mt-6">
        <x-kelas.kode-kelas-former :programOptions="$programOptions" :tipeOptions="$tipeOptions" :levelOptions="$levelOptions" :ruanganOptions="$ruanganOptions"/>

        <div class="flex flex-col input-group mt-4">
            <p class="input-label">Ruangan</p>
            <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" class="ruangan-dropdown">
                @foreach ($ruanganOptions as $ruangan)
                    <x-inputs.dropdown.option :value="$ruangan->id">{{ $ruangan->kode }}</x-inputs.dropdown.option>
                @endforeach
            </x-inputs.dropdown.select>
        </div>
        
        <hr class="my-5">

        <x-kelas.jadwal-dynamic :hariOptions="$hariOptions"/>
        
        <hr class="my-5">
        
        <x-kelas.pengajar-dynamic :pengajarOptions="$pengajarOptions"/>

        <hr class="my-5">

        <x-ui.file-peserta/>

        <hr class="my-5">
        
        <div class="flex flex-row justify-end gap-2 ">
            <a href="{{ route('kelas.index') }}" class="button-style border-none bg-white hover:bg-gray-100">Cancel</a>
            <button type="submit" class="button-style bg-green-600 border-green-600 text-white hover:bg-green-700">Simpan</button>
        </div>
    </form>

    <x-kelas.add-edit-jadwal-modal :hariOptions="$hariOptions"/>
    <x-ui.add-edit-peserta-modal/>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
    @endpush
</x-layouts.user-layout>