<x-layouts.user-layout>
  <x-slot:title>Tambah Tes</x-slot>
  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Tambah Tes</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <form action="{{ route('tes.store') }}" class="tambah-tes-form mt-6 flex flex-col bg-white p-6 shadow-sm">
    <x-tes.kode-tes-former :tipeOptions="$tipeOptions" :ruanganOptions="$ruanganOptions"></x-tes.kode-tes-former>

    <div class="mt-4 grid flex-1 grid-cols-[1fr_auto_1fr]">
      <div class="input-group">
        <p class="input-label">Waktu Mulai</p>
        <x-inputs.time inputName="waktu-mulai" placeholder="Waktu mulai" class="waktu-mulai-fp"></x-inputs.time>
      </div>
      <span class="mx-2 mt-8 text-lg">-</span>
      <div class="input-group">
        <p class="input-label">Waktu Selesai</p>
        <x-inputs.time inputName="waktu-selesai" placeholder="Waktu selesai" class="waktu-selesai-fp"></x-inputs.time>
      </div>
    </div>

    <hr class="my-5">

    <x-tes.ruangan-dynamic :ruanganOptions="$ruanganOptions" />

    <hr class="my-5">

    <x-tes.pengawas-dynamic :pengawasOptions="$pengawasOptions" />

    <hr class="my-5">

    <div class="flex flex-row justify-end gap-2">
      <a href="{{ route('tes.index') }}" class="btn btn-white border-none shadow-none">Cancel</a>
      <button type="submit" class="btn btn-green-solid">Tambah</button>
    </div>
  </form>

  @pushOnce('script')
    <script src="{{ asset('js/views/tes/tambah-tes.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
