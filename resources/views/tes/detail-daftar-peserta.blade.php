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
    <h1 class="page-title">Daftar Peserta</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  @if (auth()->user()->current_role_id == 4)
    <div class="mb-4 flex flex-row justify-end">
      <a href="{{ route('tes.daftarPeserta', ['slug' => $tes->slug]) }}" class="btn btn-green-solid"><i class="fa-solid fa-plus mr-2"></i>Tambah Peserta</a>
    </div>
  @endif

  <section id="counter-kapasitas-ruangan" class="mb-4 bg-white p-6 shadow-sm">
    <div class="flex flex-wrap divide-x divide-gray-200">
      @foreach ($tes->ruangan as $ruangan)
        <div class="flex flex-1 flex-col items-center gap-1 p-4 text-base">
          <p class="font-semibold text-upbg">{{ $ruangan->kode }}</p>
          @php
            $kapasitas = $ruangan->kapasitas;
            $peserta = $ruangan->pesertaTes->where('tes_id', $tes->id)->count();
            $color = $peserta > $kapasitas ? 'text-red-600' : '';
          @endphp
          <p class="font-medium"><span class="counter-peserta {{ $color }}" data-ruangan="{{ $ruangan->id }}">{{ $peserta }}</span> / {{ $kapasitas }}</p>
        </div>
      @endforeach
    </div>
  </section>

  <section id="daftar-peserta" class="flex flex-col">
    <div class="flex flex-col divide-y bg-white shadow-sm">
      <div class="grid grid-cols-16 items-center gap-x-4 py-4">
        <p class="col-span-2 pl-2 text-center font-semibold lg:col-span-1">No.</p>
        <p class="col-span-11 font-semibold md:col-span-7 lg:col-span-6">Peserta</p>
        <p class="hidden font-semibold lg:col-span-4 lg:block">Tanggal Bergabung</p>
        <p class="hidden font-semibold md:col-span-4 md:block lg:col-span-3">Ruangan</p>
      </div>
      @foreach ($pesertaList as $peserta)
        <div class="peserta-item grid grid-cols-16 items-center gap-x-4 py-4" data-peserta-id="{{ $peserta->id }}" data-route="{{ route('tes.updateRuangan', ['slug' => $tes->slug]) }}">
          <p class="col-span-2 pl-2 text-center font-medium lg:col-span-1">{{ $loop->iteration + ($pesertaList->currentPage() - 1) * $pesertaList->perPage() }}.</p>
          <div class="col-span-11 md:col-span-7 lg:col-span-6">
            <p class="nama-peserta w-fit font-medium text-gray-700">{{ $peserta->nama }}</p>
            <p class="nik-peserta w-fit text-gray-600">{{ $peserta->nik }}</p>
          </div>
          <div class="hidden lg:col-span-4 lg:block">
            <p class="tanggal-bergabung-peserta text-gray-600">{{ $peserta->created_at->format('d-m-Y') }}</p>
          </div>
          <div class="hidden md:col-span-4 md:flex md:justify-center lg:col-span-3">
            <x-inputs.dropdown.select name="ruangan" class="dropdown-ruangan" :selected="['text' => $peserta->pivot->ruanganTes->kode, 'value' => $peserta->pivot->ruangan_id]">
              @foreach ($tes->ruangan as $ruangan)
                <x-inputs.dropdown.option :value="$ruangan->id" class="{{ $ruangan->id == $peserta->pivot->ruangan_id ? 'selected' : '' }}">{{ "$ruangan->kode" }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          @if (auth()->user()->current_role_id == 2)
            <div class="relative col-span-3 text-center lg:col-span-2">
              <button type="button" class="btn-rounded btn-white menu border-none shadow-none"><i class="fa-solid fa-ellipsis-vertical"></i></button>
              <x-ui.dialog class="right-1/2 top-full mt-1 translate-x-4">
                <button type="button" class="edit-peserta w-full px-2 py-1.5 text-left hover:bg-gray-100">Edit</button>
                <button type="button" class="delete-peserta w-full px-2 py-1.5 text-left text-red-600 hover:bg-gray-100">Remove</button>
              </x-ui.dialog>
            </div>
          @endif
        </div>
      @endforeach
    </div>
    {{ $pesertaList->onEachSide(2)->links() }}
    {{-- <x-ui.modal id="detail-peserta-modal">
      <form action="{{ route('kelas.updatePeserta', ['slug' => $kelas->slug]) }}" class="flex flex-col gap-5">
        <h1 class="modal-title">Detail Peserta</h1>
        <input type="hidden" name="peserta-id">
        <div class="flex flex-col gap-1">
          <p class="font-semibold text-gray-700">NIK / NRP</p>
          <p class="nik-peserta">NIK / NRP Peserta</p>
        </div>
        <div class="flex flex-col gap-1">
          <p class="font-semibold text-gray-700">Nama</p>
          <p class="nama-peserta">Nama Peserta</p>
        </div>
        <div class="flex flex-col gap-1">
          <p class="font-semibold text-gray-700">Tanggal Bergabung</p>
          <p class="tanggal-bergabung-peserta">Tanggal Bergabung</p>
        </div>
        <div class="flex flex-col gap-1">
          <p class="font-semibold text-gray-700">Status</p>
          <x-inputs.checkbox type="blue" inputName="status-peserta" value="1" class="status-peserta w-fit font-medium">Aktif</x-inputs.checkbox>
        </div>
        <div class="info-container flex flex-col gap-2">
          <p class="font-semibold"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
          <ul class="list-outside list-disc space-y-1 pl-5">
            <li>Peserta yang tidak aktif tidak akan dimasukkan presensi untuk pertemuan yang akan datang</li>
            <li>Histori presensi pertemuan peserta pada kelas ini tidak akan dihapus</li>
          </ul>
        </div>
        <hr class="w-full">
        <div class="flex justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-upbg-solid">Simpan</button>
        </div>
      </form>
    </x-ui.modal>

    <x-ui.modal id="delete-peserta-modal">
      <form action="{{ route('kelas.destroyPeserta', ['slug' => $kelas->slug]) }}" class="flex flex-col gap-5">
        <h1 class="modal-title">Hapus Peserta</h1>
        <input type="hidden" name="peserta-id">
        <p>Apakah anda yakin ingin menghapus <span class="nama-nik-peserta font-bold">Peserta</span> dari kelas ini?</p>
        <div class="danger-container flex flex-col gap-2">
          <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
          <p>Data pertemuan peserta pada kelas ini akan dihapus permanen</p>
        </div>
        <hr class="w-full">
        <div class="flex flex-row items-center justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-red-solid">Remove</button>
        </div>
      </form>
    </x-ui.modal> --}}
  </section>

  @pushOnce('script')
    <script src="{{ asset('js/views/tes/detail-daftar-peserta-tes.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
