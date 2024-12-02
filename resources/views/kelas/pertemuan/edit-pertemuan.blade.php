<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</x-slot>
    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-3xl">Edit Pertemuan</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>
    
    <form id="edit-pertemuan-form" action="{{ route('kelas.pertemuan.updateDetail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="bg-white p-6 shadow-sm grid grid-cols-2 gap-y-4 gap-x-2">
        <div class="just-wrapper col-span-2">
            <x-inputs.dropdown :selected="$terlaksanaSelected" :options="$terlaksanaOptions" inputName="terlaksana" label="Status" placeholder="Pilih status"/>
        </div>
        <div class="just-wrapper col-span-2">
            <x-inputs.dropdown :selected="$pengajarSelected" :options="$pengajarOptions" inputName="pengajar-id" label="Pengajar" placeholder="Pilih pengajar"/>
        </div>
        <div class="just-wrapper col-span-2">
            <x-inputs.date inputName="tanggal" label="Tanggal" placeholder="Pilih tanggal" value="{{ $pertemuan->tanggal }}"/>
        </div>
        <x-inputs.time inputName="waktu-mulai" label="Waktu mulai" placeholder="Pilih waktu mulai" :value="$pertemuan->waktu_mulai"/>
        <x-inputs.time inputName="waktu-selesai" label="Waktu selesai" placeholder="Pilih waktu selesai" :value="$pertemuan->waktu_selesai"/>
        <div class="just-wrapper col-span-2">
            <x-inputs.dropdown :selected="$ruanganSelected" :options="$ruanganOptions" inputName="ruangan-kode" label="Ruangan" placeholder="Pilih ruangan"/>
        </div>
        <hr class="col-span-2 my-5">
        <div class="col-span-2 flex flex-row justify-end items-center gap-4">
            <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="button-style border-none bg-white text-gray-700 hover:bg-gray-100">Cancel</a>
            <button type="submit" class="button-style border-upbg bg-upbg text-white hover:bg-upbg-dark">Simpan</button>
        </div>
    </form>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/components/ui/modal.js') }}"></script>
        <script src="{{ asset('js/views/kelas/pertemuan/edit-pertemuan.js') }}"></script>
    @endpush
</x-layouts.user-layout>