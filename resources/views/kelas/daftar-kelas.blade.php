<x-layouts.user-layout>
  <x-slot:title>Daftar Kelas</x-slot>
  <div class="mb-8 mt-6 flex flex-row items-center justify-between gap-2">
    <h1 class="page-title">Daftar Kelas</h1>
    @if (auth()->user()->current_role_id == 2)
      <a href="{{ route('kelas.create') }}" class="btn btn-green-solid"><i class="fa-solid fa-plus mr-2"></i>Tambah Kelas</a>
    @endif
  </div>

  <section id="filter-kelas" class="mb-4">
    <form action="{{ route('kelas.index') }}" method="GET" class="filter-form flex flex-col gap-2">
      <div class="grid grid-cols-[1fr_fit-content(150px)] sm:grid-cols-[fit-content(150px)_1fr_fit-content(150px)]">
        <button type="button" class="open-filter btn col-span-full row-span-1 row-start-2 mt-2 border-none bg-white text-sm sm:col-auto sm:row-auto sm:mr-2 sm:mt-0 sm:flow-root">Filter<i class="fa-solid fa-chevron-down ml-2 text-xs transition-transform before:hidden sm:before:inline"></i><i class="fa-solid fa-chevron-right ml-2 text-xs sm:before:hidden"></i></button>
        <input type="search" name="kode" value="{{ $selected['kode'] }}" placeholder="Cari kode kelas" class="input-outline flex-1 rounded-sm-md px-2 py-2 shadow-sm">
        <button type="submit" class="submit-out-filter btn btn-upbg-solid ml-2 text-xs sm:text-sm"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
      </div>

      <div class="filter-container fixed inset-0 z-[100] flex -translate-x-full flex-col overflow-y-scroll bg-white px-4 pb-28 pt-4 transition-all sm:static sm:z-0 sm:max-h-0 sm:translate-x-0 sm:overflow-hidden sm:py-0">
        <div class="mb-8 flex flex-row items-center justify-between text-xl font-semibold text-gray-700 sm:hidden">
          <p>Filter Kelas</p>
          <button type="button" class="close-filter btn-rounded btn-white border-none text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-4 lg:grid-cols-3 xl:grid-cols-4">
          <div class="input-group">
            <p class="input-label">Program Kelas</p>
            <x-inputs.dropdown.select name="program" placeholder="Semua" class="program-dropdown filter-field" :selected="$selected['program'] ? ['text' => $selected['program']->nama . ' (' . $selected['program']->kode . ')', 'value' => $selected['program']->id] : null">
              @foreach ($programOptions as $program)
                <x-inputs.dropdown.option :value="$program->id" class="{{ $selected['program'] && $selected['program']->id == $program->id ? 'selected' : '' }}">{{ "$program->nama ($program->kode)" }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          <div class="input-group">
            <p class="input-label">Tipe Kelas</p>
            <x-inputs.dropdown.select name="tipe" placeholder="Semua" class="tipe-dropdown filter-field" :selected="$selected['tipe'] ? ['text' => $selected['tipe']->nama . ' (' . $selected['tipe']->kode . ')', 'value' => $selected['tipe']->id] : null">
              @foreach ($tipeOptions as $tipe)
                <x-inputs.dropdown.option :value="$tipe->id" class="{{ $selected['tipe'] && $selected['tipe']->id == $tipe->id ? 'selected' : '' }}">{{ "$tipe->nama ($tipe->kode)" }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          <div class="input-group">
            <p class="input-label">Nomor Kelas</p>
            <input type="number" name="nomor" value="{{ $selected['nomor'] }}" class="input-appearance input-outline filter-field" placeholder="Semua">
          </div>
          <div class="input-group">
            <p class="input-label">Level Kelas</p>
            <x-inputs.dropdown.select name="level" placeholder="Semua" class="level-dropdown filter-field" :selected="$selected['level'] ? ['text' => $selected['level']->nama . ' (' . $selected['level']->kode . ')', 'value' => $selected['level']->id] : null">
              @foreach ($levelOptions as $level)
                <x-inputs.dropdown.option :value="$level->id" class="{{ $selected['level'] && $selected['level']->id == $level->id ? 'selected' : '' }}">{{ "$level->nama ($level->kode)" }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          <div class="input-group">
            <p class="input-label">Banyak Pertemuan</p>
            <input type="number" name="banyak-pertemuan" value="{{ $selected['banyak-pertemuan'] }}" class="input-appearance input-outline filter-field" placeholder="Semua">
          </div>
          <div class="input-group">
            <p class="input-label">Tanggal Mulai</p>
            <x-inputs.date inputName="tanggal-mulai" class="filter-field" value="{{ $selected['tanggal-mulai'] }}" placeholder="Semua" plugin="month" />
          </div>
          <div class="input-group">
            <p class="input-label">Ruangan</p>
            <x-inputs.dropdown.select name="ruangan" placeholder="Semua" class="ruangan-dropdown filter-field" :selected="$selected['ruangan'] ? ['text' => $selected['ruangan']->kode, 'value' => $selected['ruangan']->id] : null">
              @foreach ($ruanganOptions as $ruangan)
                <x-inputs.dropdown.option :value="$ruangan->id" class="{{ $selected['ruangan'] && $selected['ruangan']->id == $ruangan->id ? 'selected' : '' }}">{{ $ruangan->kode }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          <div class="input-group">
            <p class="input-label">Status</p>
            <x-inputs.dropdown.select name="status" placeholder="Semua" class="status-dropdown filter-field" :selected="$selected['status'] ? ['text' => $selected['status']['text'], 'value' => $selected['status']['value']] : null">
              @foreach ($statusOptions as $status)
                <x-inputs.dropdown.option value="{{ $status['value'] }}" class="{{ $selected['status'] && $selected['status']['value'] == $status['value'] ? 'selected' : '' }}">{{ $status['text'] }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          <div class="input-group @if (auth()->user()->current_role_id == 3) sm:col-span-2 lg:col-span-1 xl:col-span-2 @endif">
            <p class="input-label">Sort By</p>
            <x-inputs.dropdown.select name="order" placeholder="None" class="sort-dropdown filter-field" :selected="$selected['sortby'] ? ['text' => $selected['sortby']['text'], 'value' => $selected['sortby']['value']] : null">
              @foreach ($sortbyOptions as $sortby)
                <x-inputs.dropdown.option value="{{ $sortby['value'] }}" class="{{ $selected['sortby'] && $selected['sortby']['value'] == $sortby['value'] ? 'selected' : '' }}">{{ $sortby['text'] }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          @if (auth()->user()->current_role_id == 2)
            <div class="input-group">
              <p class="input-label">Pengajar</p>
              <x-inputs.dropdown.select name="pengajar" placeholder="Semua" class="pengajar-dropdown filter-field" :selected="$selected['pengajar'] ? ['text' => $selected['pengajar']->nama . ' (' . $selected['pengajar']->nik . ' )', 'value' => $selected['pengajar']->id] : null">
                @foreach ($pengajarOptions as $pengajar)
                  <x-inputs.dropdown.option :value="$pengajar->id" class="{{ $selected['pengajar'] && $selected['pengajar']->id == $pengajar->id ? 'selected' : '' }}">{{ "$pengajar->nama ($pengajar->nik)" }}</x-inputs.dropdown.option>
                @endforeach
              </x-inputs.dropdown.select>
            </div>
          @endif
          <hr class="sm:hidden">
          <div class="input-group sm:hidden">
            <p class="input-label">Kode Kelas</p>
            <input type="search" name="kode" value="{{ $selected['kode'] }}" placeholder="Cari kode kelas" class="input-appearance input-outline w-full">
          </div>
          <button type="submit" class="btn btn-upbg-solid self-end text-sm sm:col-span-1 sm:col-start-2 sm:row-span-1 sm:row-start-6 lg:col-span-1 lg:col-start-3 lg:row-span-1 lg:row-start-4 xl:col-span-1 xl:col-start-4 xl:row-span-1 xl:row-start-3"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
          <button type="button" class="reset-filter btn btn-red-outline self-end text-sm sm:col-span-1 sm:col-start-1 sm:row-span-1 sm:row-start-6 lg:col-span-1 lg:col-start-2 lg:row-span-1 lg:row-start-4 xl:col-span-1 xl:col-start-3 xl:row-span-1 xl:row-start-3">Reset Filter</button>
        </div>
      </div>
    </form>
  </section>

  <section id="daftar-kelas" class="flex flex-col lg:shadow-sm">
    <div class="hidden border-b bg-white p-4 lg:grid lg:grid-cols-6 lg:gap-x-4 xl:grid-cols-7">
      <p class="col-span-2 font-semibold">Kode Kelas</p>
      <p class="col-span-2 font-semibold">Jadwal</p>
      <p class="col-span-1 font-semibold">Ruangan</p>
      <p class="col-span-1 font-semibold xl:col-span-2">Progress</p>
    </div>
    <div class="kelas-container flex flex-col gap-3 lg:gap-0 lg:divide-y">
      @if ($kelasList->isEmpty())
        <div class="kelas-item grid grid-cols-1 gap-y-3 rounded-sm-md bg-white p-4 shadow-sm lg:grid-cols-6 lg:gap-x-4 lg:gap-y-0 lg:rounded-none lg:shadow-none xl:grid-cols-7">
          <p class="empty-query col-span-full">Tidak ada data yang cocok</p>
        </div>
      @else
        @foreach ($kelasList as $kelas)
          <div class="kelas-item grid grid-cols-1 gap-y-3 rounded-sm-md bg-white p-4 shadow-sm lg:grid-cols-6 lg:gap-x-4 lg:gap-y-0 lg:rounded-none lg:shadow-none xl:grid-cols-7">
            <div class="flex flex-row items-center lg:col-span-2">
              <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="truncate font-semibold text-upbg underline decoration-transparent transition hover:decoration-upbg">{{ $kelas->kode }}</a>
            </div>
            <div class="flex flex-col justify-center lg:col-span-2">
              <div class="flex flex-col gap-2 text-gray-700">
                @foreach ($kelas->jadwal as $jadwal)
                  <p><i class="fa-solid fa-calendar-days mr-2"></i><span class="mr-2">{{ $jadwal->namaHari }}</span><i class="fa-regular fa-clock mr-2"></i><span>{{ $jadwal->waktu_mulai->format('H:i') }} - {{ $jadwal->waktu_selesai->format('H:i') }}</span></p>
                @endforeach
              </div>
            </div>
            <div class="flex flex-col justify-center lg:col-span-1">
              <p class="text-gray-700"><i class="fa-regular fa-building mr-2"></i>{{ $kelas->ruangan->kode }}</p>
            </div>
            <div class="flex flex-col items-end justify-center gap-1 lg:col-span-1 xl:col-span-2">
              <span class="font-medium text-gray-700">{{ $kelas->progress . '/' . $kelas->banyak_pertemuan }} Pertemuan</span>
              <div class="h-1.5 w-full rounded border bg-slate-200 shadow-inner">
                @php
                  $progress = ($kelas->progress / $kelas->banyak_pertemuan) * 100;
                  $bgcolor = $progress == 100 ? 'bg-green-600' : 'bg-upbg';
                @endphp
                <div style="width: {{ $progress }}%" class="{{ $bgcolor }} h-full rounded-full"></div>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </section>
  {{ $kelasList->onEachSide(2)->links() }}

  @pushOnce('script')
    <script src="{{ asset('js/views/kelas/daftar-kelas.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
