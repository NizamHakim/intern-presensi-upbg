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
    <h1 class="page-title">Detail Kelas</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <section id="detail-kelas" class="mt-6 flex flex-col gap-6 bg-white p-6 shadow-sm md:flex-row md:justify-between">
    <div class="flex flex-col gap-6">
      <h2 class="truncate text-xl font-semibold text-gray-700 md:text-2xl">{{ $kelas->kode }}</h2>
      <div class="flex flex-col">
        <h3 class="mb-1 font-semibold text-gray-700">Pengajar:</h3>
        <ul class="list-none">
          @foreach ($kelas->pengajar as $pengajar)
            <li>{{ $pengajar->nama }}</li>
          @endforeach
        </ul>
      </div>
      <div class="flex flex-col">
        <h3 class="mb-2 font-semibold text-gray-700">Jadwal:</h3>
        <div class="flex flex-col gap-2 text-gray-700">
          @foreach ($kelas->jadwal as $jadwal)
            <p><i class="fa-solid fa-calendar-days mr-2"></i><span class="mr-2">{{ $jadwal->namaHari }}</span><i class="fa-regular fa-clock mr-2"></i><span>{{ $jadwal->waktu_mulai->format('H:i') }} - {{ $jadwal->waktu_selesai->format('H:i') }}</span></p>
          @endforeach
        </div>
      </div>
      <div class="flex flex-col">
        <h3 class="mb-1 font-semibold text-gray-700">Ruangan:</h3>
        <span class="text-gray-700"><i class="fa-regular fa-building mr-2"></i>{{ $kelas->ruangan->kode }}</span>
      </div>
      <div class="flex flex-col">
        <h3 class="mb-1 font-semibold text-gray-700">WhatsApp Group:</h3>
        @if ($kelas->group_link)
          <a href="{{ $kelas->group_link }}" target="_blank" class="break-all text-upbg underline decoration-transparent transition hover:text-upbg-light hover:decoration-upbg-light">{{ $kelas->group_link }}</a>
        @else
          <span class="text-gray-700">-</span>
        @endif
      </div>
    </div>
    @if (auth()->user()->current_role_id == 2)
      <div class="flex h-fit flex-col gap-2 md:flex-row">
        <a href="{{ route('kelas.edit', ['slug' => $kelas->slug]) }}" class="btn btn-upbg-outline"><i class="fa-regular fa-pen-to-square mr-2"></i>Edit</a>
        <button type="button" class="delete-kelas btn btn-red-outline"><i class="fa-regular fa-trash-can mr-2"></i>Delete</button>
      </div>
    @endif
    <x-ui.modal id="delete-kelas-modal">
      <form action="{{ route('kelas.destroy', ['slug' => $kelas->slug]) }}" method="POST">
        @csrf
        @method('DELETE')
        <h1 class="modal-title mb-5">Hapus Kelas</h1>
        <p class="mb-3 text-gray-700">Apakah anda yakin ingin menghapus kelas <span class="kode-kelas font-bold">{{ $kelas->kode }}</span></p>
        <div class="danger-container flex flex-col gap-2">
          <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
          <p>Semua data kelas ini akan dihapus permanen</p>
        </div>
        <hr class="my-5 w-full">
        <div class="flex flex-row justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-red-solid">Delete</button>
        </div>
      </form>
    </x-ui.modal>
  </section>

  <section id="pertemuan-terlaksana" class="mt-6 flex flex-col gap-6 bg-white p-6 shadow-sm md:flex-row md:items-center md:justify-between">
    <div class="flex flex-col items-center gap-2 md:items-start">
      <p class="text-lg text-gray-700 md:text-2xl">Pertemuan Terlaksana</p>
      <p class="text-3xl font-semibold text-gray-700 md:text-4xl">{{ $kelas->progress }} / {{ $kelas->banyak_pertemuan }}</p>
    </div>
    <button type="button" class="tambah-pertemuan btn btn-green-solid"><i class="fa-solid fa-plus mr-2"></i><span>Tambah Pertemuan</span></button>
    <x-ui.modal id="tambah-pertemuan-modal">
      <form action="{{ route('kelas.pertemuan.store', ['slug' => $kelas->slug]) }}" class="flex flex-col gap-5">
        <h1 class="modal-title">Tambah Pertemuan</h1>
        <div class="input-group">
          <p class="input-label">Tanggal</p>
          <x-inputs.date inputName="tanggal" placeholder="Pilih tanggal" />
        </div>
        <div class="grid grid-cols-2 gap-x-4">
          <div class="input-group">
            <p class="input-label">Waktu mulai</p>
            <x-inputs.time inputName="waktu-mulai" placeholder="Waktu mulai" />
          </div>
          <div class="input-group">
            <p class="input-label">Waktu selesai</p>
            <x-inputs.time inputName="waktu-selesai" placeholder="Waktu selesai" />
          </div>
        </div>
        <div class="input-group">
          <p class="input-label">Ruangan</p>
          <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan">
            @foreach ($ruanganOptions as $ruangan)
              <x-inputs.dropdown.option>{{ $ruangan->kode }}</x-inputs.dropdown.option>
            @endforeach
          </x-inputs.dropdown.select>
        </div>
        <hr class="w-full">
        <div class="flex flex-row justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-green-solid">Tambah</button>
        </div>
      </form>
    </x-ui.modal>
  </section>

  <section id="daftar-pertemuan" class="mt-6 divide-y bg-white shadow-sm">
    <div class="hidden grid-cols-16 items-center gap-x-4 py-4 lg:grid">
      <p class="pl-2 text-center font-semibold lg:col-span-2 xl:col-span-2">Pertemuan ke-</p>
      <p class="font-semibold lg:col-span-5 xl:col-span-4">Jadwal</p>
      <p class="font-semibold lg:col-span-4 xl:col-span-5">Pengajar</p>
      <p class="font-semibold lg:col-span-2 xl:col-span-3">Status</p>
    </div>
    @if ($kelas->pertemuan->isEmpty())
      <div class="rounded-sm-md bg-white p-4 shadow-sm lg:rounded-none lg:shadow-none">
        <p class="empty-query">Tidak ada data yang cocok</p>
      </div>
    @else
      @foreach ($kelas->pertemuan as $pertemuan)
        <div class="flex flex-col gap-4 lg:grid lg:grid-cols-16 lg:items-center lg:gap-x-4 lg:gap-y-0 lg:py-4">
          <div class="order-1 bg-upbg-dark px-4 py-2 lg:order-none lg:col-span-2 lg:bg-inherit lg:py-0 lg:pl-2 lg:pr-0 xl:col-span-2">
            <p class="text-base font-medium text-white lg:hidden">Pertemuan ke - {{ $pertemuan->pertemuan_ke }}</p>
            <p class="hidden text-center text-2xl font-semibold text-gray-700 lg:block">{{ $pertemuan->pertemuan_ke }}</p>
          </div>
          <div class="order-3 px-4 lg:order-none lg:col-span-5 lg:px-0 xl:col-span-4">
            <h3 class="mb-1 font-semibold text-gray-700 lg:hidden">Jadwal:</h3>
            <p class="text-gray-700"><i class="fa-solid fa-calendar-days mr-2"></i>{{ $pertemuan->tanggal->isoFormat('dddd, D MMMM YYYY') }}</p>
            <p class="text-gray-700"><i class="fa-regular fa-clock mr-2"></i>{{ $pertemuan->waktu_mulai->isoFormat('HH:mm') . ' - ' . $pertemuan->waktu_selesai->isoFormat('HH:mm') }}</p>
            <p class="text-gray-700"><i class="fa-regular fa-building mr-2"></i>{{ $pertemuan->ruangan->kode }}</p>
          </div>
          <div class="order-4 px-4 lg:order-none lg:col-span-4 lg:px-0 xl:col-span-5">
            <h3 class="font-semibold text-gray-700 lg:hidden">Pengajar:</h3>
            <p class="text-gray-700">{{ $pertemuan->pengajar_id ? $pertemuan->pengajar->nama : '-' }}</p>
          </div>
          <div class="order-2 px-4 lg:order-none lg:col-span-2 lg:px-0 xl:col-span-3">
            <h3 class="font-semibold text-gray-700 lg:hidden">Status:</h3>
            @if ($pertemuan->terlaksana)
              <p class="font-semibold text-green-600">Terlaksana</p>
            @else
              @if (now()->isAfter($pertemuan->waktu_selesai))
                <p class="font-semibold text-red-600">Tidak Terlaksana</p>
              @else
                <p class="text-gray-700">-</p>
              @endif
            @endif
          </div>
          <div class="order-5 mb-5 flex flex-col px-4 text-center lg:order-none lg:col-span-3 lg:mb-0 lg:block lg:px-0 xl:col-span-2">
            <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="btn btn-upbg-outline">View<i class="fa-solid fa-circle-arrow-right ml-2"></i></a>
          </div>
        </div>
      @endforeach
    @endif
  </section>

  @pushOnce('script')
    <script src="{{ asset('js/views/kelas/detail-daftar-pertemuan.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
