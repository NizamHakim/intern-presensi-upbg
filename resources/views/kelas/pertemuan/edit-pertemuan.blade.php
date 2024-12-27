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
    <h1 class="page-title">Edit Pertemuan</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <form id="edit-pertemuan-form" action="{{ route('kelas.pertemuan.updateDetail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="grid grid-cols-2 gap-x-2 gap-y-4 bg-white p-6 shadow-sm">
    <div class="input-group col-span-2">
      <p class="input-label">Status</p>
      <x-inputs.dropdown.select name="terlaksana" :selected="['text' => $pertemuan->terlaksana ? 'Terlaksana' : 'Tidak Terlaksana', 'value' => $pertemuan->terlaksana]" class="terlaksana-dropdown">
        <x-inputs.dropdown.option :value="0" class="{{ $pertemuan->terlaksana == 0 ? 'selected' : '' }}">Tidak Terlaksana</x-inputs.dropdown.option>
        <x-inputs.dropdown.option :value="1" class="{{ $pertemuan->terlaksana == 1 ? 'selected' : '' }}">Terlaksana</x-inputs.dropdown.option>
      </x-inputs.dropdown.select>
    </div>
    <div class="input-group col-span-2">
      <p class="input-label">Pengajar</p>
      <x-inputs.dropdown.select name="pengajar-id" placeholder="Pilih pengajar" :selected="$pertemuan->pengajar_id ? ['text' => $pertemuan->pengajar->nama, 'value' => $pertemuan->pengajar->id] : null" class="pengajar-dropdown">
        @foreach ($kelas->pengajar as $pengajar)
          <x-inputs.dropdown.option :value="$pengajar->id" class="{{ $pertemuan->pengajar_id == $pengajar->id ? 'selected' : '' }}">{{ "$pengajar->nama" }}</x-inputs.dropdown.option>
        @endforeach
      </x-inputs.dropdown.select>
    </div>
    <div class="input-group col-span-2">
      <p class="input-label">Tanggal</p>
      <x-inputs.date inputName="tanggal" value="{{ $pertemuan->tanggal->format('Y-m-d') }}" placeholder="Pilih tanggal" />
    </div>
    <div class="input-group">
      <p class="input-label">Waktu mulai</p>
      <x-inputs.time inputName="waktu-mulai" :value="$pertemuan->waktu_mulai" placeholder="Waktu mulai" />
    </div>
    <div class="input-group">
      <p class="input-label">Waktu selesai</p>
      <x-inputs.time inputName="waktu-selesai" :value="$pertemuan->waktu_selesai" placeholder="Waktu selesai" />
    </div>

    <div class="input-group col-span-2">
      <p class="input-label">Ruangan</p>
      <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" :selected="['text' => $pertemuan->ruangan->kode, 'value' => $pertemuan->ruangan_id]" class="ruangan-dropdown">
        @foreach ($ruanganOptions as $ruangan)
          <x-inputs.dropdown.option :value="$ruangan->id" class="{{ $ruangan->id == $pertemuan->ruangan_id ? 'selected' : '' }}">{{ "$ruangan->kode" }}</x-inputs.dropdown.option>
        @endforeach
      </x-inputs.dropdown.select>
    </div>
    <hr class="col-span-2">
    <div class="col-span-2 flex flex-row items-center justify-end gap-4">
      <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="btn btn-white border-none shadow-none">Cancel</a>
      <button type="submit" class="btn btn-upbg-solid">Simpan</button>
    </div>
  </form>

  @pushOnce('script')
    <script src="{{ asset('js/views/kelas/pertemuan/edit-pertemuan.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
