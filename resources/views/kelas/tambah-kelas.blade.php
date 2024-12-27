<x-layouts.user-layout>
  <x-slot:title>Tambah Kelas</x-slot>
  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Tambah Kelas</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <form action="{{ route('kelas.store') }}" class="tambah-kelas-form mt-6 flex min-w-0 flex-col bg-white p-6 shadow-sm">
    <x-kelas.kode-kelas-former :programOptions="$programOptions" :tipeOptions="$tipeOptions" :levelOptions="$levelOptions" :ruanganOptions="$ruanganOptions" />

    <div class="input-group mt-4 flex flex-col">
      <p class="input-label">Ruangan</p>
      <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" class="ruangan-dropdown">
        @foreach ($ruanganOptions as $ruangan)
          <x-inputs.dropdown.option :value="$ruangan->id">{{ $ruangan->kode }}</x-inputs.dropdown.option>
        @endforeach
      </x-inputs.dropdown.select>
    </div>

    <div class="input-group mt-4 flex flex-col">
      <p class="input-label">Whatsapp Group Link (opsional)</p>
      <input type="text" name="group-link" class="input-appearance input-outline" placeholder="https://chat.whatsapp.com/">
    </div>

    <hr class="my-5">

    <x-kelas.jadwal-dynamic :hariOptions="$hariOptions" />

    <hr class="my-5">

    <x-kelas.pengajar-dynamic :pengajarOptions="$pengajarOptions" />

    <hr class="my-5">

    <x-ui.file-peserta />

    <hr class="my-5">

    <div class="flex flex-row justify-end gap-2">
      <a href="{{ route('kelas.index') }}" class="btn btn-white border-none shadow-none">Cancel</a>
      <button type="submit" class="btn btn-green-solid">Tambah</button>
    </div>
  </form>

  @pushOnce('script')
    <script src="{{ asset('js/views/kelas/tambah-kelas.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
