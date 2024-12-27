<x-layouts.user-layout>
  <x-slot:title>{{ $kelas->kode }} | Edit</x-slot>
  <x-slot:sidenav>
    <x-layouts.navgroup title="{{ $kelas->kode }}">
      <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
      <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
    </x-layouts.navgroup>
    <hr>
  </x-slot>

  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Edit Kelas</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <form action="{{ route('kelas.update', ['slug' => $kelas->slug]) }}" class="edit-form mt-6 flex flex-col bg-white p-6 shadow-sm">
    <x-kelas.kode-kelas-former :programOptions="$programOptions" :tipeOptions="$tipeOptions" :levelOptions="$levelOptions" :ruanganOptions="$ruanganOptions" :kelas="$kelas" />

    <div class="input-group mt-4 flex flex-col">
      <p class="input-label">Ruangan</p>
      <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" :selected="['text' => $kelas->ruangan->kode, 'value' => $kelas->ruangan->id]" class="ruangan-dropdown">
        @foreach ($ruanganOptions as $ruangan)
          <x-inputs.dropdown.option :value="$ruangan->id" class="{{ $ruangan->id == $kelas->ruangan->id ? 'selected' : '' }}">{{ $ruangan->kode }}</x-inputs.dropdown.option>
        @endforeach
      </x-inputs.dropdown.select>
    </div>

    <div class="input-group mt-4 flex flex-col">
      <p class="input-label">Whatsapp Group Link (opsional)</p>
      <input type="text" name="group-link" value="{{ $kelas->group_link }}" class="input-appearance input-outline" placeholder="https://chat.whatsapp.com/">
    </div>

    <hr class="my-5">

    <x-kelas.jadwal-dynamic :hariOptions="$hariOptions" :kelas="$kelas" />

    <hr class="my-5">

    <x-kelas.pengajar-dynamic :pengajarOptions="$pengajarOptions" :kelas="$kelas" />

    <hr class="my-5">

    <div class="flex flex-row justify-end gap-2">
      <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="btn btn-white border-none shadow-none">Cancel</a>
      <button type="submit" class="btn btn-green-solid">Simpan</button>
    </div>
  </form>

  @push('script')
    <script src="{{ asset('js/views/kelas/edit-kelas.js') }}"></script>
  @endpush
</x-layouts.user-layout>
