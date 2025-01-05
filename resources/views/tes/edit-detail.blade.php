<x-layouts.user-layout>
  <x-slot:title>{{ $tes->kode }}</x-slot>
  <x-slot:sidenav>
    <x-layouts.navgroup title="{{ $tes->kode }}">
      <x-layouts.navlink href="{{ route('tes.detail', ['slug' => $tes->slug]) }}" routeName="tes.detail">Detail Tes</x-layouts.navlink>
      <x-layouts.navlink href="{{ route('tes.daftarPeserta', ['slug' => $tes->slug]) }}" routeName="tes.daftarPeserta">Daftar Peserta</x-layouts.navlink>
    </x-layouts.navgroup>
    <hr>
  </x-slot>

  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Edit Tes</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <form action="{{ route('tes.update', ['slug' => $tes->slug]) }}" class="edit-form mt-6 flex flex-col bg-white p-6 shadow-sm">
    <x-tes.kode-tes-former :tes="$tes" :tipeOptions="$tipeOptions" :ruanganOptions="$ruanganOptions"></x-tes.kode-tes-former>

    <div class="mt-4 grid flex-1 grid-cols-[1fr_auto_1fr]">
      <div class="input-group">
        <p class="input-label">Waktu Mulai</p>
        <x-inputs.time :value="$tes->waktu_mulai" inputName="waktu-mulai" placeholder="Waktu mulai" class="waktu-mulai-fp"></x-inputs.time>
      </div>
      <span class="mx-2 mt-8 text-lg">-</span>
      <div class="input-group">
        <p class="input-label">Waktu Selesai</p>
        <x-inputs.time :value="$tes->waktu_selesai" inputName="waktu-selesai" placeholder="Waktu selesai" class="waktu-selesai-fp"></x-inputs.time>
      </div>
    </div>

    <hr class="my-5">

    <x-tes.ruangan-dynamic :tes="$tes" :ruanganOptions="$ruanganOptions" />

    <hr class="my-5">

    <x-tes.pengawas-dynamic :tes="$tes" :pengawasOptions="$pengawasOptions" />

    <hr class="my-5">

    <div class="flex flex-row justify-end gap-2">
      <a href="{{ route('tes.detail', ['slug' => $tes->slug]) }}" class="btn btn-white border-none shadow-none">Cancel</a>
      <button type="submit" class="btn btn-upbg-solid">Simpan</button>
    </div>
  </form>

  @pushOnce('script')
    <script src="{{ asset('js/views/tes/edit-tes.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
