<x-layouts.user-layout>
    <x-slot:title>{{ $kelas->kode }} | Edit</x-slot>
    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-3xl">Edit Kelas</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <form action="" class="edit-form flex flex-col bg-white p-6 shadow-sm mt-6">
        <div class="flex flex-col col-span-full">
            <h1 class="text-gray-700 font-medium mb-1">Kode Kelas</h1>
            <input name="kode-kelas" readonly type="text" placeholder="Pilih kategori untuk membuat kode kelas" class="input-style">
        </div>
        <hr class="my-5">
        <section id="kode" class="grid grid-cols-6 gap-x-3 gap-y-4">
            <x-inputs.dropdown :selected="$programSelected" :options="$programOptions" inputName="program-kode" label="Program" placeholder="Pilih program" class="col-span-full kode-former md:col-span-3 xl:col-span-2"/>
            <x-inputs.dropdown :selected="$tipeSelected" :options="$tipeOptions" inputName="tipe-kode" label="Tipe" placeholder="Pilih tipe" class="col-span-full kode-former md:col-span-3 xl:col-span-2"/>
            <div class="flex flex-col col-span-full input-group kode-former md:col-span-3 xl:col-span-2">
                <label class="text-gray-700 font-medium mb-1">Nomor Kelas</label>
                <input type="number" name="nomor-kelas" class="input-style input-number" placeholder="Nomor kelas">
            </div>
            <x-inputs.dropdown :selected="$levelSelected" :options="$levelOptions" inputName="level-kode" label="Level" placeholder="Pilih level" class="col-span-full kode-former md:col-span-3 xl:col-span-2"/>
            <div class="flex flex-col col-span-full input-group kode-former md:col-span-3 xl:col-span-2">
                <label class="text-gray-700 font-medium mb-1">Banyak Pertemuan</label>
                <input type="number" name="banyak-pertemuan" class="input-style input-number" placeholder="Banyak pertemuan">
            </div>
            <x-inputs.date inputName="tanggal-mulai" label="Tanggal mulai" placeholder="Pilih tanggal mulai" class="col-span-full kode-former md:col-span-3 xl:col-span-2"/>
            <x-inputs.dropdown :selected="$ruanganSelected" :options="$ruanganOptions" inputName="ruangan-kode" label="Ruangan" placeholder="Pilih ruangan" class="col-span-full"/>
        </section>
        <hr class="my-5">
        <section class="flex flex-col gap-2">
            <h1 class="text-gray-700 font-medium">Pengajar</h1>
            <div class="pengajar-container flex flex-col gap-3">
                <div class="dropdown-pengajar flex flex-row gap-3">
                    <x-inputs.dropdown :selected="$pengajarSelected" :options="$pengajarOptions" inputName="pengajar[]" placeholder="Pilih pengajar" class="flex-1"/>
                </div>
            </div>
            <div class="flex flex-row items-center gap-4 mt-1">
                <hr class="flex-1">
                <button type="button" class="tambah-pengajar font-medium text-gray-600 size-10 border rounded-full text-lg transition hover:text-white hover:bg-green-600 hover:border-green-600"><i class="fa-solid fa-plus"></i></button>
                <hr class="flex-1">
            </div>
        </section>
        <hr class="my-5">
        <div class="flex flex-row justify-end gap-2 ">
            <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="button-style border-none bg-white hover:bg-gray-100">Cancel</a>
            <button type="submit" class="button-style bg-green-600 border-green-600 text-white hover:bg-green-700">Simpan</button>
        </div>
    </form>
    
    @push('script')
        <script src="{{ asset('js/views/kelas/edit-kelas.js') }}"></script>
    @endpush
</x-layouts.user-layout>