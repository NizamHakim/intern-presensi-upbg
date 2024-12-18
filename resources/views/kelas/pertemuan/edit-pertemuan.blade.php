<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</x-slot>
    <x-slot:sidenav>
        <x-layouts.navgroup title="Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}">
            <x-layouts.navlink href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" routeName="kelas.pertemuan.detail">Detail Pertemuan</x-layouts.navlink>
        </x-layouts.navgroup>
        <x-layouts.navgroup title="{{ $kelas->kode }}">
            <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
            <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
        </x-layouts.navgroup>
        <hr>
    </x-slot>

    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-3xl">Edit Pertemuan</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>
    
    <form id="edit-pertemuan-form" action="{{ route('kelas.pertemuan.updateDetail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="bg-white p-6 shadow-sm grid grid-cols-2 gap-y-4 gap-x-2">
        <div class="input-group col-span-2">
            <p class="input-label">Status</p>
            <x-inputs.dropdown.select name="terlaksana" :selected="['text' => ($pertemuan->terlaksana) ? 'Terlaksana' : 'Tidak Terlaksana', 'value' => $pertemuan->terlaksana]" class="terlaksana-dropdown">
                <x-inputs.dropdown.option :value="0" class="{{ ($pertemuan->terlaksana == 0) ? 'selected' : '' }}">Tidak Terlaksana</x-inputs.dropdown.option>
                <x-inputs.dropdown.option :value="1" class="{{ ($pertemuan->terlaksana == 1) ? 'selected' : '' }}">Terlaksana</x-inputs.dropdown.option>
            </x-inputs.dropdown.select>
        </div>
        <div class="input-group col-span-2">
            <p class="input-label">Pengajar</p>
            <x-inputs.dropdown.select name="pengajar-id" placeholder="Pilih pengajar" :selected="($pertemuan->pengajar_id) ? ['text' => $pertemuan->pengajar->nama, 'value' => $pertemuan->pengajar->id] : null" class="pengajar-dropdown">
                @foreach ($kelas->pengajar as $pengajar)
                    <x-inputs.dropdown.option :value="$pengajar->id" class="{{ ($pertemuan->pengajar_id == $pengajar->id) ? 'selected' : '' }}">{{ "$pengajar->nama" }}</x-inputs.dropdown.option>
                @endforeach
            </x-inputs.dropdown.select>
        </div>
        <div class="input-group col-span-2">
            <p class="input-label">Tanggal</p>
            <x-inputs.date inputName="tanggal" value="{{ $pertemuan->tanggal->format('Y-m-d') }}" placeholder="Pilih tanggal"/>
        </div>
        <div class="input-group">
            <p class="input-label">Waktu mulai</p>
            <x-inputs.time inputName="waktu-mulai" :value="$pertemuan->waktu_mulai" placeholder="Waktu mulai"/>
        </div>
        <div class="input-group">
            <p class="input-label">Waktu selesai</p>
            <x-inputs.time inputName="waktu-selesai" :value="$pertemuan->waktu_selesai" placeholder="Waktu selesai"/>
        </div>
        
        <div class="input-group col-span-2">
            <p class="input-label">Ruangan</p>
            <x-inputs.dropdown.select name="ruangan-id" placeholder="Pilih ruangan" :selected="['text' => $pertemuan->ruangan->kode, 'value' => $pertemuan->ruangan_id]" class="ruangan-dropdown">
                @foreach ($ruanganOptions as $ruangan)
                    <x-inputs.dropdown.option :value="$ruangan->id" class="{{ ($ruangan->id == $pertemuan->ruangan_id) ? 'selected' : '' }}">{{ "$ruangan->kode" }}</x-inputs.dropdown.option>
                @endforeach
            </x-inputs.dropdown.select>
        </div>
        <hr class="col-span-2">
        <div class="col-span-2 flex flex-row justify-end items-center gap-4">
            <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="button-style border-none bg-white text-gray-700 hover:bg-gray-100">Cancel</a>
            <button type="submit" class="button-style button-upbg-solid">Simpan</button>
        </div>
    </form>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/pertemuan/edit-pertemuan.js') }}"></script>
    @endpush
</x-layouts.user-layout>