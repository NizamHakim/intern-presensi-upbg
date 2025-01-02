<x-layouts.user-layout>
  <x-slot:title>{{ $peserta->nama }}</x-slot>
  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Detail Peserta</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <section id="detail-peserta" class="flex flex-col gap-8 bg-white p-6 shadow-sm sm:flex-row sm:justify-between">
    <div class="flex flex-col gap-4">
      <div class="flex flex-col gap-1">
        <p class="font-medium">NIK / NRP</p>
        <p class="nik-peserta text-wrap">{{ $peserta->nik }}</p>
      </div>
      <div class="flex flex-col gap-1">
        <p class="font-medium">Nama</p>
        <p class="nama-peserta text-wrap">{{ $peserta->nama }}</p>
      </div>
      <div class="flex flex-col gap-1">
        <p class="font-medium">Dept. / Occupation</p>
        <p class="occupation-peserta text-wrap">{{ $peserta->occupation }}</p>
      </div>
    </div>
    <div class="flex h-fit flex-col gap-2 sm:flex-row">
      <button type="button" class="edit-peserta btn btn-upbg-outline sm:h-fit">Edit</button>
      <button type="button" class="delete-peserta btn btn-red-outline sm:h-fit">Delete</button>
    </div>

    <x-ui.modal id="edit-peserta-modal">
      <form action="{{ route('peserta.update', ['id' => $peserta->id]) }}" class="flex flex-col gap-5">
        <h1 class="modal-title">Edit Peserta</h1>
        <div class="input-group flex flex-col">
          <p class="input-label">NIK / NRP</p>
          <input type="text" name="nik" placeholder="NIK / NRP" class="input-appearance input-outline">
        </div>
        <div class="input-group flex flex-col">
          <p class="input-label">Nama</p>
          <input type="text" name="nama" placeholder="Nama" class="input-appearance input-outline">
        </div>
        <div class="input-group flex flex-col">
          <p class="input-label">Dept. / Occupation</p>
          <input type="text" name="occupation" placeholder="Dept. / Occupation" class="input-appearance input-outline">
        </div>
        <hr>
        <div class="flex flex-row items-center justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-upbg-solid">Simpan</button>
        </div>
      </form>
    </x-ui.modal>

    <x-ui.modal id="delete-peserta-modal">
      <form action="{{ route('peserta.destroy', ['id' => $peserta->id]) }}" class="flex flex-col gap-5">
        <h1 class="modal-title">Hapus Peserta</h1>
        <p>Apakah anda yakin ingin menghapus <span class="font-semibold">{{ $peserta->nama }} - {{ $peserta->nik }}</span> ?</p>
        <div class="danger-container flex flex-col gap-2">
          <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
          <p>Peserta akan dihapus dari semua kelas dan tes yang terasosiasi dengannya</p>
        </div>
        <hr>
        <div class="flex flex-row items-center justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-red-solid">Delete</button>
        </div>
      </form>
    </x-ui.modal>
  </section>



  <section id="history-kelas" class="mt-8 flex flex-col bg-white p-6 shadow-sm">
    <x-inputs.date inputName="tanggal" placeholder="Semua" plugin="month" />
    <h1 class="mb-2 mt-4 font-semibold">Histori Kelas</h1>
    <div class="grid grid-cols-1 divide-y border">
      <div class="grid grid-cols-12 divide-x">
        <p class="col-span-2 px-2 py-2 text-center font-medium sm:col-span-1">No</p>
        <p class="col-span-10 px-4 py-2 font-medium sm:col-span-11">Kode Kelas</p>
      </div>
      @if ($peserta->kelas->isEmpty())
        <p class="py-4 text-center font-medium">Tidak ada data yang cocok</p>
      @else
        @foreach ($peserta->kelas as $kelas)
          <div class="grid grid-cols-12 divide-x">
            <p class="col-span-2 truncate px-2 py-2 text-center sm:col-span-1">{{ $loop->iteration }}</p>
            <div class="col-span-10 truncate px-4 py-2 sm:col-span-11">
              <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="text-upbg underline decoration-transparent transition hover:text-upbg-light hover:decoration-upbg-light">{{ $kelas->kode }}</a>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </section>

  <section id="history-tes" class="mt-8 flex flex-col bg-white p-6 shadow-sm">
    <x-inputs.date inputName="tanggal" placeholder="Semua" plugin="month" />
    <h1 class="mb-2 mt-4 font-semibold">Histori Tes</h1>
    <div class="grid grid-cols-1 divide-y border">
      <div class="grid grid-cols-12 divide-x">
        <p class="col-span-2 px-2 py-2 text-center font-medium sm:col-span-1">No</p>
        <p class="col-span-10 px-4 py-2 font-medium sm:col-span-11">Kode Tes</p>
      </div>
      @if ($peserta->tes->isEmpty())
        <p class="py-4 text-center font-medium">Tidak ada data yang cocok</p>
      @else
        @foreach ($peserta->tes as $tes)
          <div class="grid grid-cols-12 divide-x">
            <p class="col-span-2 truncate px-2 py-2 text-center sm:col-span-1">{{ $loop->iteration }}</p>
            <div class="col-span-10 truncate px-4 py-2 sm:col-span-11">
              <a href="{{ route('tes.detail', ['slug' => $tes->slug]) }}" class="text-upbg underline decoration-transparent transition hover:text-upbg-light hover:decoration-upbg-light">{{ $tes->kode }}</a>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </section>

  @pushOnce('script')
    <script src="{{ asset('js/views/peserta/detail-peserta.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
