<x-layouts.user-layout>
  <x-slot:title>Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</x-slot>
  <x-slot:sidenav>
    <x-layouts.navgroup title="Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}">
      <x-layouts.navlink href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" routeName="kelas.pertemuan.detail">Detail Pertemuan</x-layouts.navlink>
    </x-layouts.navgroup>
    <hr>
    <x-layouts.navgroup title="{{ $kelas->kode }}">
      <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
      <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
    </x-layouts.navgroup>
    <hr>
  </x-slot>

  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Detail Pertemuan</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <section id="detail-pertemuan" class="mt-6 flex flex-col gap-6 bg-white p-6 shadow-sm md:flex-row md:justify-between">
    <div class="flex flex-col gap-6">
      <h2 class="text-xl font-semibold text-gray-700 md:text-2xl">Pertemuan ke - {{ $pertemuan->pertemuan_ke }}</h2>
      <div class="flex flex-col">
        <h3 class="mb-1 font-semibold text-gray-700">Status:</h3>
        @if ($pertemuan->terlaksana)
          <span class="font-semibold text-green-600">Terlaksana</span>
        @else
          @if (now()->isAfter($pertemuan->waktu_selesai))
            <span class="font-semibold text-red-600">Tidak Terlaksana</span>
          @else
            <span class="font-semibold text-gray-600">-</span>
          @endif
        @endif
      </div>
      <div class="flex flex-col">
        <h3 class="mb-1 font-semibold text-gray-700">Pengajar:</h3>
        @if ($pertemuan->pengajar_id)
          <p>{{ $pertemuan->pengajar->nama }}</p>
        @else
          <span class="font-semibold text-gray-700">-</span>
        @endif
      </div>
      <div class="flex flex-col">
        <h3 class="mb-2 font-semibold text-gray-700">Jadwal:</h3>
        <div class="flex flex-col gap-2 text-gray-700">
          <p><i class="fa-solid fa-calendar-days mr-2"></i>{{ $pertemuan->tanggal->isoFormat('dddd, D MMMM YYYY') }}</p>
          <p><i class="fa-regular fa-clock mr-2"></i>{{ $pertemuan->waktu_mulai->isoFormat('HH:mm') . ' - ' . $pertemuan->waktu_selesai->isoFormat('HH:mm') }}</p>
          <p><i class="fa-regular fa-building mr-2"></i>{{ $pertemuan->ruangan->kode }}</p>
        </div>
      </div>
    </div>
    <div class="flex h-fit flex-col gap-2 md:flex-row">
      @if (auth()->user()->current_role_id == 2)
        <a href="{{ route('kelas.pertemuan.edit', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="edit-pertemuan btn btn-upbg-outline"><i class="fa-regular fa-pen-to-square mr-2"></i>Edit</a>
      @elseif (auth()->user()->current_role_id == 3 && !$pertemuan->terlaksana)
        <button type="button" class="reschedule-pertemuan btn btn-upbg-outline"><i class="fa-regular fa-calendar-check mr-2"></i>Reschedule</button>
        <x-ui.modal id="reschedule-pertemuan-modal">
          <form action="{{ route('kelas.pertemuan.reschedule', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="flex flex-col gap-5">
            <h1 class="modal-title">Reschedule Pertemuan</h1>
            <div class="input-group">
              <p class="input-label">Tanggal</p>
              <x-inputs.date inputName="tanggal" :value="$pertemuan->tanggal" placeholder="Pilih tanggal" />
            </div>
            <div class="flex w-full flex-row items-start gap-4">
              <div class="input-group flex-1">
                <p class="input-label">Waktu mulai</p>
                <x-inputs.time inputName="waktu-mulai" :value="$pertemuan->waktu_mulai" placeholder="Waktu mulai" />
              </div>
              <div class="input-group flex-1">
                <p class="input-label">Waktu selesai</p>
                <x-inputs.time inputName="waktu-selesai" :value="$pertemuan->waktu_selesai" placeholder="Waktu selesai" />
              </div>
            </div>
            <div class="input-group">
              <p class="input-label">Ruangan</p>
              <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" :selected="['text' => $pertemuan->ruangan->kode, 'value' => $pertemuan->ruangan->id]">
                @foreach ($ruanganOptions as $ruangan)
                  <x-inputs.dropdown.option :value="$ruangan->id" class="{{ $ruangan->id == $pertemuan->ruangan->id ? 'selected' : '' }}">{{ $ruangan->kode }}</x-inputs.dropdown.option>
                @endforeach
              </x-inputs.dropdown.select>
            </div>
            <hr class="w-full">
            <div class="flex flex-row justify-end gap-4">
              <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
              <button type="submit" class="submit-button btn btn-upbg-solid">Simpan</button>
            </div>
          </form>
        </x-ui.modal>
      @endif
      <button type="button" class="delete-pertemuan btn btn-red-outline"><i class="fa-regular fa-trash-can mr-2"></i>Delete</button>
    </div>

    <x-ui.modal id="delete-pertemuan-modal">
      <form action="{{ route('kelas.pertemuan.destroy', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('DELETE')
        <h1 class="modal-title">Hapus Pertemuan</h1>
        <p class="text-gray-700">Apakah anda yakin ingin menghapus <span class="font-semibold">Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</span> dari kelas <span class="font-semibold">{{ $kelas->kode }}</span></p>
        <div class="danger-container flex flex-col gap-2">
          <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
          <p>Semua data pertemuan ini akan dihapus permanen</p>
        </div>
        <hr class="w-full">
        <div class="flex flex-row justify-end gap-4">
          <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
          <button type="submit" class="submit-button btn btn-red-solid">Delete</button>
        </div>
      </form>
    </x-ui.modal>
  </section>

  <section id="topik-catatan" class="mt-6 flex flex-col gap-4 bg-white p-6 shadow-sm" data-slug="{{ $kelas->slug }}" data-id="{{ $pertemuan->id }}">
    <div class="topik input-group flex flex-col gap-2">
      <h3 class="font-semibold text-gray-700">Topik Bahasan</h3>
      <p class="text-wrap break-words text-gray-600">{!! $pertemuan->topik ? $pertemuan->topik : '-' !!}</p>
    </div>
    <div class="catatan input-group flex flex-col gap-2">
      <h3 class="font-semibold text-gray-700">Catatan</h3>
      <p class="text-wrap break-words text-gray-600">{!! $pertemuan->catatan ? $pertemuan->catatan : '-' !!}</p>
    </div>
    <button class="edit-topik-catatan btn btn-upbg-outline"><i class="fa-regular fa-pen-to-square mr-2"></i>Edit</button>
  </section>

  @if (!$pertemuan->terlaksana)
    @if (auth()->user()->current_role_id == 3)
      <section id="notice-presensi" class="mt-6 flex flex-col items-center gap-4 bg-white p-6 shadow-sm">
        @if (now()->isBefore($pertemuan->waktu_selesai))
          <p class="text-center text-gray-600">Mulai pertemuan untuk membuat daftar kehadiran</p>
          <button @if (now()->isBefore($pertemuan->waktuMulai)) disabled @endif type="button" class="mulai-pertemuan btn btn-upbg-solid disabled:opacity-70 disabled:hover:bg-upbg">Mulai Pertemuan</button>
          @if (now()->isBefore($pertemuan->waktuMulai))
            <p class="countdown-label text-center text-gray-600">Pertemuan dapat dimulai dalam,<br><span data-waktu-mulai="{{ $pertemuan->waktu_mulai }}" class="countdown font-semibold text-upbg">0d 0h 0m 0s</span></p>
          @endif

          <x-ui.modal id="mulai-pertemuan-modal">
            <form action="{{ route('kelas.pertemuan.mulaiPertemuan', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="flex flex-col gap-5">
              <h1 class="modal-title">Mulai Pertemuan</h1>
              <input type="hidden" name="terlaksana" value="1">
              <div class="input-group">
                <p class="input-label">Pilih pengajar</p>
                <x-inputs.dropdown.select name="pengajar-id" placeholder="Pilih pengajar" class="pengajar-dropdown">
                  @foreach ($pengajarOptions as $pengajar)
                    <x-inputs.dropdown.option :value="$pengajar->id">{{ $pengajar->nama }}</x-inputs.dropdown.option>
                  @endforeach
                </x-inputs.dropdown.select>
              </div>
              <hr class="w-full">
              <div class="mt-6 flex flex-row justify-end gap-4">
                <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
                <button type="submit" class="submit-button btn btn-upbg-solid">Mulai</button>
              </div>
            </form>
          </x-ui.modal>
        @else
          <p class="text-base font-semibold text-red-600">Pertemuan telah selesai</p>
          <p class="text-center text-gray-600">Silahkan <span class="font-semibold">Reschedule</span> pertemuan atau tambahkan <span class="font-semibold">Catatan</span> alasan pertemuan tidak terlaksana untuk admin</p>
        @endif
      </section>
    @endif
  @else
    <section id="daftar-presensi" class="mt-6 flex flex-col shadow-sm">
      <div class="flex flex-col gap-6 bg-white p-6 md:flex-row md:justify-between">
        <div class="flex flex-col items-center gap-2 md:items-start">
          <p class="text-lg text-gray-700 md:text-2xl">Kehadiran Peserta</p>
          <p class="hadir-count text-3xl font-semibold text-gray-700 md:text-4xl">{{ $pertemuan->hadirCount }} / {{ $pertemuan->presensi->count() }}</p>
        </div>
        <div class="flex flex-col justify-center gap-2">
          <button type="button" class="tambah-presensi btn btn-green-solid"><i class="fa-solid fa-plus mr-2"></i><span>Tambah Presensi</span></button>
          <form action="{{ route('presensi.updatePresensiAll', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="tandai-semua-hadir flex w-full min-w-[195px] flex-col">
            <button type="submit" class="btn btn-green-outline"><i class="fa-regular fa-square-check mr-2"></i>Tandai Semua Hadir</button>
          </form>
          <x-ui.modal id="tambah-presensi-modal">
            <div class="flex flex-col gap-5">
              <h1 class="modal-title">Tambah Presensi</h1>
              @if ($tambahPesertaOptions->isEmpty())
                <div class="flex flex-col gap-4">
                  <div class="success-container">
                    <p class="mb-2 font-semibold text-green-600"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
                    <p class="text-green-600">Semua peserta sudah ditambahkan ke pertemuan ini</p>
                  </div>
                  <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
                </div>
              @else
                <form action="{{ route('presensi.store', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="flex flex-col gap-5">
                  <div class="input-group">
                    <p class="input-label">Pilih peserta</p>
                    <x-inputs.dropdown.select name="peserta-id" placeholder="Pilih peserta" class="peserta-dropdown">
                      @foreach ($tambahPesertaOptions as $peserta)
                        <x-inputs.dropdown.option :value="$peserta->id">{{ $peserta->nama . ' (' . $peserta->nik . ')' }}</x-inputs.dropdown.option>
                      @endforeach
                    </x-inputs.dropdown.select>
                  </div>
                  <div class="input-group">
                    <p class="input-label">Status kehadiran</p>
                    <x-inputs.dropdown.select name="hadir" :selected="['text' => 'Hadir', 'value' => 1]" class="status-dropdown">
                      <x-inputs.dropdown.option :value="0">Tidak Hadir</x-inputs.dropdown.option>
                      <x-inputs.dropdown.option :value="1" class="selected">Hadir</x-inputs.dropdown.option>
                    </x-inputs.dropdown.select>
                  </div>
                  <div class="success-container">
                    <p class="mb-2 font-semibold text-green-600"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
                    <p class="text-green-600">Jika peserta tidak ada dalam daftar, pastikan peserta sudah terdaftar di kelas ini</p>
                  </div>
                  <hr class="w-full">
                  <div class="flex flex-row justify-end gap-4">
                    <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
                    <button type="submit" class="submit-button btn btn-green-solid">Tambah</button>
                  </div>
                </form>
              @endif
            </div>
          </x-ui.modal>
        </div>
      </div>

      <div class="presensi-container flex flex-col divide-y border-t bg-white">
        <div class="grid grid-cols-12 items-center gap-x-3 py-4">
          <p class="col-span-2 pl-2 text-center font-semibold sm:col-span-1">No.</p>
          <p class="col-span-5 font-semibold sm:col-span-6">Peserta</p>
          <p class="col-span-3 font-semibold sm:col-span-4">Status Kehadiran</p>
        </div>
        @if ($pertemuan->presensi->isEmpty())
          <div class="rounded-sm-md bg-white p-4 shadow-sm lg:rounded-none lg:shadow-none">
            <p class="empty-query">Tidak ada data yang cocok</p>
          </div>
        @else
          @foreach ($pertemuan->presensi as $presensi)
            <div class="presensi-item grid grid-cols-12 items-center gap-x-3 py-5" data-presensi-id="{{ $presensi->id }}">
              <p class="col-span-2 pl-2 text-center font-medium sm:col-span-1">{{ $loop->iteration }}.</p>
              <div class="col-span-5 sm:col-span-6">
                <p class="nama-peserta w-fit font-medium text-gray-700">{{ $presensi->peserta->nama }}</p>
                <p class="nik-peserta w-fit text-gray-600">{{ $presensi->peserta->nik }}</p>
              </div>
              <form action="{{ route('presensi.updatePresensi', ['slug' => $kelas->slug, 'id' => $pertemuan->id, 'presensiId' => $presensi->id]) }}" class="form-toggle-kehadiran col-span-3 sm:col-span-4">
                @if ($presensi->hadir)
                  <button type="submit" name="hadir" value="1" class="btn-hadir btn-rounded btn-white active">H</button>
                  <button type="submit" name="hadir" value="0" class="btn-alfa btn-rounded btn-white">A</button>
                @else
                  <button type="submit" name="hadir" value="1" class="btn-hadir btn-rounded btn-white">H</button>
                  <button type="submit" name="hadir" value="0" class="btn-alfa btn-rounded btn-white active">A</button>
                @endif
              </form>
              <div class="relative col-span-2 text-center sm:col-span-1">
                <button type="button" class="menu btn-rounded btn-white border-none shadow-none"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                <x-ui.dialog class="right-1/2 top-full mt-1 translate-x-4">
                  <button type="button" class="delete-presensi w-full px-2 py-1.5 text-left text-red-600 hover:bg-gray-100">Delete</button>
                </x-ui.dialog>
              </div>
            </div>
          @endforeach
        @endif
      </div>
      <x-ui.modal id="delete-presensi-modal">
        <form action="{{ route('presensi.destroy', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="flex flex-col gap-5">
          <h1 class="modal-title">Hapus Presensi</h1>
          <input type="hidden" name="presensi-id">
          <p>Apakah anda yakin ingin menghapus <span class="nama-nik-peserta font-bold">Peserta</span> dari pertemuan ini?</p>
          <div class="danger-container flex flex-col gap-2">
            <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
            <p>Data peserta pada pertemuan ini akan dihapus permanen</p>
          </div>
          <hr class="w-full">
          <div class="flex flex-row items-center justify-end gap-4">
            <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
            <button type="submit" class="submit-button btn btn-red-solid">Delete</button>
          </div>
        </form>
      </x-ui.modal>
    </section>
  @endif

  @pushOnce('script')
    <script src="{{ asset('js/utils/countdown.js') }}"></script>
    <script src="{{ asset('js/views/kelas/pertemuan/detail-pertemuan.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
