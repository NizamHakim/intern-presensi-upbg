<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    <x-slot:title>{{ $kelas->kode }} | Edit</x-slot>
    <x-slot:sidenav>
        <x-layouts.navgroup title="{{ $kelas->kode }}">
            <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
            <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
        </x-layouts.navgroup>
        <hr>
    </x-slot>

    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-3xl">Edit Kelas</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <form action="{{ route('kelas.update', ['slug' => $kelas->slug]) }}" class="edit-form flex flex-col bg-white p-6 shadow-sm mt-6">
        <x-kelas.kode-kelas-former :programOptions="$programOptions" :tipeOptions="$tipeOptions" :levelOptions="$levelOptions" :ruanganOptions="$ruanganOptions" :kelas="$kelas"/>

        <div class="flex flex-col input-group mt-4">
            <p class="input-label">Ruangan</p>
            <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" :selected="['text' => $kelas->ruangan->kode, 'value' => $kelas->ruangan->id]" class="ruangan-dropdown">
                @foreach ($ruanganOptions as $ruangan)
                    <x-inputs.dropdown.option :value="$ruangan->id" class="{{ ($ruangan->id == $kelas->ruangan->id) ? 'selected' : '' }}">{{ $ruangan->kode }}</x-inputs.dropdown.option>
                @endforeach
            </x-inputs.dropdown.select>
        </div>

        <hr class="my-5">

        <x-kelas.jadwal-dynamic :hariOptions="$hariOptions" :kelas="$kelas"/>
        
        <hr class="my-5">
        
        <x-kelas.pengajar-dynamic :pengajarOptions="$pengajarOptions" :kelas="$kelas"/>
        
        <hr class="my-5">
        
        <div class="flex flex-row justify-end gap-2 ">
            <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="button-style border-none bg-white hover:bg-gray-100">Cancel</a>
            <button type="submit" class="button-style bg-green-600 border-green-600 text-white hover:bg-green-700">Simpan</button>
        </div>
    </form>

    <x-kelas.add-edit-jadwal-modal :hariOptions="$hariOptions"/>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/edit-kelas.js') }}"></script>
    @endpush
</x-layouts.user-layout>