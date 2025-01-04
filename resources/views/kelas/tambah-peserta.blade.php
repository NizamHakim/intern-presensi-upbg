<x-layouts.user-layout>
  <x-slot:title>{{ $kelas->kode }}</x-slot>
  <x-slot:sidenav>
    <x-layouts.navgroup title="{{ $kelas->kode }}">
      <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
      <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
    </x-layouts.navgroup>
    <hr>
  </x-slot>

  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Tambah Peserta</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <div class="flex flex-col bg-white p-6 shadow-sm">
    <form action="{{ route('kelas.storePeserta', ['slug' => $kelas->slug]) }}" class="tambah-peserta-form">
      <x-kelas.file-peserta :required="true" />

      <hr class="my-5">

      <div class="flex flex-row justify-end gap-2">
        <a href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" class="cancel-button btn btn-white border-none shadow-none">Cancel</a>
        <button type="submit" class="submit-button btn btn-green-solid">Tambah</button>
      </div>
    </form>
  </div>

  @pushOnce('script')
    <script src="{{ asset('js/views/kelas/tambah-peserta.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
