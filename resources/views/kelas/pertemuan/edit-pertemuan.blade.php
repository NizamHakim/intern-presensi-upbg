<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</x-slot>
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-[2rem]">Edit Pertemuan</h1>
        </div>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>
    
    <form id="edit-pertemuan-form" action="{{ route('kelas.pertemuan.updateDetail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="flex flex-col gap-4">
        <x-inputs.dropdown :selected="$terlaksanaSelected" :options="$terlaksanaOptions" inputName="terlaksana" label="Status" placeholder="Pilih status"/>
        <x-inputs.dropdown :selected="$pengajarSelected" :options="$pengajarOptions" inputName="pengajar-id" label="Pengajar" placeholder="Pilih pengajar"/>
        <div class="flex flex-row items-start gap-4">
            <x-inputs.date inputName="tanggal" label="Tanggal" placeholder="Pilih tanggal" value="{{ $pertemuan->tanggal }}"/>
            <x-inputs.time inputName="waktu-mulai" label="Waktu mulai" placeholder="Pilih waktu mulai" :value="$pertemuan->waktu_mulai"/>
            <x-inputs.time inputName="waktu-selesai" label="Waktu selesai" placeholder="Pilih waktu selesai" :value="$pertemuan->waktu_selesai"/>
        </div>
        <x-inputs.dropdown :selected="$ruanganSelected" :options="$ruanganOptions" inputName="ruangan-kode" label="Ruangan" placeholder="Pilih ruangan"/>
        <hr class="bg-gray-200 my-5">
        <div class="flex flex-row justify-end items-center gap-4">
            <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="px-10 py-2 rounded-md bg-gray-100 text-gray-600 font-medium transition duration-300 hover:bg-gray-200">Cancel</a>
            <button type="submit" class="px-10 py-2 rounded-md bg-upbg text-white font-medium transition duration-300 hover:bg-upbg-dark">Simpan</button>
        </div>
    </form>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/components/ui/modal.js') }}"></script>
        <script src="{{ asset('js/views/kelas/pertemuan/edit-pertemuan.js') }}"></script>
    @endpush
</x-layouts.user-layout>