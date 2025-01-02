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
    <h1 class="page-title">Detail Tes</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <section id="detail-tes" class="mt-6 flex flex-col gap-6 bg-white p-6 shadow-sm md:flex-row md:justify-between">
    <div class="flex flex-col gap-6">
      <h2 class="text-xl font-semibold text-gray-700 md:text-2xl">{{ $tes->kode }}</h2>
      <div class="flex flex-col">
        <h3 class="mb-1 font-semibold text-gray-700">Status:</h3>
        @if ($tes->terlaksana)
          <span class="font-semibold text-green-600">Terlaksana</span>
        @else
          @if (now()->isAfter($tes->waktu_selesai))
            <span class="font-semibold text-red-600">Tidak Terlaksana</span>
          @else
            <span class="font-semibold text-gray-600">-</span>
          @endif
        @endif
      </div>
      <div class="flex flex-col">
        <h3 class="mb-1 font-semibold text-gray-700">Pengawas:</h3>
        <ul class="list-none">
          @foreach ($tes->pengawas as $pengawas)
            <li><a href="{{ route('user.detail', ['id' => $pengawas->id]) }}" class="underline decoration-transparent transition hover:text-upbg-light hover:decoration-upbg-light">{{ $pengawas->nama }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="flex flex-col">
        <h3 class="mb-2 font-semibold text-gray-700">Jadwal:</h3>
        <div class="flex flex-col gap-2 text-gray-700">
          <p><i class="fa-solid fa-calendar-days mr-2"></i>{{ $tes->tanggal->isoFormat('dddd, D MMMM YYYY') }}</p>
          <p><i class="fa-regular fa-clock mr-2"></i>{{ $tes->waktu_mulai->isoFormat('HH:mm') }} - {{ $tes->waktu_selesai->isoFormat('HH:mm') }}</p>
        </div>
      </div>
      <div class="flex flex-col">
        <h3 class="mb-1 font-semibold text-gray-700">Ruangan:</h3>
        @foreach ($tes->ruangan as $ruangan)
          <span class="text-gray-700"><i class="fa-regular fa-building mr-2"></i>{{ $ruangan->kode }}</span>
        @endforeach
      </div>
    </div>
    @if (auth()->user()->current_role_id == 4)
      <div class="flex h-fit flex-col gap-2 md:flex-row">
        <a href="{{ route('tes.edit', ['slug' => $tes->slug]) }}" class="btn btn-upbg-outline"><i class="fa-regular fa-pen-to-square mr-2"></i>Edit</a>
        <button type="button" class="delete-tes btn btn-red-outline"><i class="fa-regular fa-trash-can mr-2"></i>Delete</button>
      </div>
    @endif
    <x-ui.modal id="delete-tes-modal">
      <form action="{{ route('tes.destroy', ['slug' => $tes->slug]) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('DELETE')
        <h1 class="modal-title">Hapus Tes</h1>
        <p class="text-gray-700">Apakah anda yakin ingin menghapus tes <span class="kode-tes font-bold">{{ $tes->kode }}</span></p>
        <div class="danger-container flex flex-col gap-2">
          <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
          <p>Semua data tes ini akan dihapus permanen</p>
        </div>
        <hr class="w-full">
        <div class="flex flex-row justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-red-solid">Delete</button>
        </div>
      </form>
    </x-ui.modal>
  </section>

  <section id="daftar-peserta" class="mt-6 flex flex-col shadow-sm">
    <div class="flex flex-col gap-6 bg-white p-6 md:flex-row md:justify-between">
      <div class="flex flex-col items-center gap-2 md:items-start">
        <p class="text-lg text-gray-700 md:text-2xl">Kehadiran Peserta</p>
        <p class="hadir-count text-3xl font-semibold text-gray-700 md:text-4xl">
          @if ($tes->peserta->isEmpty())
            0 / 0
          @else
            {{ $tes->hadirCount }} / {{ $tes->peserta->count() }}
          @endif
        </p>
      </div>
      <div class="flex min-w-60 flex-col justify-center gap-2">
        <p class="font-semibold text-gray-600 md:text-right">Ruangan</p>
        <x-inputs.dropdown.select name="ruangan" placeholder="Semua" class="filter-ruangan" data-tes-route="{{ route('tes.detail', ['slug' => $tes->slug]) }}">
          @foreach ($tes->ruangan as $ruangan)
            <x-inputs.dropdown.option :value="$ruangan->id">{{ "$ruangan->kode" }}</x-inputs.dropdown.option>
          @endforeach
        </x-inputs.dropdown.select>
      </div>
    </div>

    <div class="peserta-container flex flex-col divide-y border-t bg-white">
      <x-tes.presensi-peserta :tes="$tes" :pesertaList="$pesertaList" />
    </div>

    <x-ui.modal id="delete-peserta-modal">
      <form action="{{ route('tes.destroyPresensi', ['slug' => $tes->slug]) }}" class="flex flex-col gap-5">
        <h1 class="modal-title">Hapus Peserta</h1>
        <input type="hidden" name="peserta-id">
        <p>Apakah anda yakin ingin menghapus <span class="nama-nik-peserta font-bold">Peserta</span> dari tes ini?</p>
        <div class="danger-container flex flex-col gap-2">
          <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
          <p>Data kehadiran peserta pada tes ini akan dihapus permanen</p>
        </div>
        <hr class="w-full">
        <div class="flex flex-row items-center justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-red-solid">Delete</button>
        </div>
      </form>
    </x-ui.modal>
  </section>

  @pushOnce('script')
    <script src="{{ asset('js/views/tes/detail-tes.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
