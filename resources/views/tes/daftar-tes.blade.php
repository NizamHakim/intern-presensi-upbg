<x-layouts.user-layout>
  <x-slot:title>Daftar Tes</x-slot>
  <div class="mb-8 mt-6 flex flex-row items-center justify-between gap-2">
    <h1 class="page-title">Daftar Tes</h1>
    @if (auth()->user()->current_role_id == 4)
      <a href="{{ route('tes.create') }}" class="btn btn-green-solid"><i class="fa-solid fa-plus mr-2"></i>Tambah Tes</a>
    @endif
  </div>

  <section id="filter-tes" class="mb-4">
    <form action="{{ route('tes.index') }}" method="GET" class="filter-form flex flex-col gap-2">
      <div class="grid grid-cols-[1fr_fit-content(150px)] sm:grid-cols-[fit-content(150px)_1fr_fit-content(150px)]">
        <button type="button" class="open-filter btn col-span-full row-span-1 row-start-2 mt-2 border-none bg-white text-sm transition sm:col-auto sm:row-auto sm:mr-2 sm:mt-0 sm:flow-root">Filter<i class="fa-solid fa-chevron-down ml-2 text-xs transition-transform before:hidden sm:before:inline"></i><i class="fa-solid fa-chevron-right ml-2 text-xs sm:before:hidden"></i></button>
        <input type="search" name="kode" value="{{ $selected['kode'] }}" placeholder="Cari kode tes" class="input-outline flex-1 rounded-sm-md px-2 py-2 shadow-sm">
        <button type="submit" class="submit-out-filter btn btn-upbg-solid ml-2 text-xs sm:text-sm"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
      </div>

      <div class="filter-container fixed inset-0 z-[100] flex -translate-x-full flex-col overflow-y-scroll bg-white px-4 pb-28 pt-4 transition-all sm:static sm:z-0 sm:max-h-0 sm:translate-x-0 sm:overflow-hidden sm:py-0">
        <div class="mb-8 flex flex-row items-center justify-between text-xl font-semibold text-gray-700 sm:hidden">
          <p>Filter Tes</p>
          <button type="button" class="close-filter btn-rounded btn-white border-none text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-4 lg:grid-cols-3 xl:grid-cols-4">
          <div class="input-group">
            <p class="input-label">Tipe Tes</p>
            <x-inputs.dropdown.select name="tipe" placeholder="Semua" class="tipe-dropdown filter-field" :selected="$selected['tipe'] ? ['text' => $selected['tipe']->nama . ' (' . $selected['tipe']->kode . ')', 'value' => $selected['tipe']->id] : null">
              @foreach ($tipeOptions as $tipe)
                <x-inputs.dropdown.option :value="$tipe->id" class="{{ $selected['tipe'] && $selected['tipe']->id == $tipe->id ? 'selected' : '' }}">{{ "$tipe->nama ($tipe->kode)" }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          <div class="input-group">
            <p class="input-label">Nomor Tes</p>
            <input type="number" name="nomor" value="{{ $selected['nomor'] }}" class="input-appearance input-outline filter-field" placeholder="Semua">
          </div>
          <div class="input-group">
            <p class="input-label">Tanggal Tes</p>
            <x-inputs.date inputName="tanggal" class="filter-field" value="{{ $selected['tanggal'] }}" placeholder="Semua" plugin="month" />
          </div>
          <div class="input-group">
            <p class="input-label">Ruangan</p>
            <x-inputs.dropdown.select name="ruangan" placeholder="Semua" class="ruangan-dropdown filter-field" :selected="$selected['ruangan'] ? ['text' => $selected['ruangan']->kode . ' (' . $selected['ruangan']->kapasitas . ')', 'value' => $selected['ruangan']->id] : null">
              @foreach ($ruanganOptions as $ruangan)
                <x-inputs.dropdown.option :value="$ruangan->id" class="{{ $selected['ruangan'] && $selected['ruangan']->id == $ruangan->id ? 'selected' : '' }}">{{ $ruangan->kode . ' (' . $ruangan->kapasitas . ')' }}</x-inputs.dropdown.option>
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
          <div class="input-group">
            <p class="input-label">Sort By</p>
            <x-inputs.dropdown.select name="order" placeholder="None" class="sort-dropdown filter-field" :selected="$selected['order'] ? ['text' => $selected['order']['text'], 'value' => $selected['order']['value']] : null">
              @foreach ($sortbyOptions as $sortby)
                <x-inputs.dropdown.option value="{{ $sortby['value'] }}" class="{{ $selected['order'] && $selected['order']['value'] == $sortby['value'] ? 'selected' : '' }}">{{ $sortby['text'] }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          @if (auth()->user()->current_role_id == 4)
            <div class="input-group xl:col-span-2">
              <p class="input-label">Pengawas</p>
              <x-inputs.dropdown.select name="pengawas" placeholder="Semua" class="pengawas-dropdown filter-field" :selected="$selected['pengawas'] ? ['text' => $selected['pengawas']->nama . ' (' . $selected['pengawas']->nik . ' )', 'value' => $selected['pengawas']->id] : null">
                @foreach ($pengawasOptions as $pengawas)
                  <x-inputs.dropdown.option :value="$pengawas->id" class="{{ $selected['pengawas'] && $selected['pengawas']->id == $pengawas->id ? 'selected' : '' }}">{{ "$pengawas->nama ($pengawas->nik)" }}</x-inputs.dropdown.option>
                @endforeach
              </x-inputs.dropdown.select>
            </div>
          @endif
          <hr class="sm:hidden">
          <div class="input-group sm:hidden">
            <p class="input-label">Kode Tes</p>
            <input type="search" name="kode" value="{{ $selected['kode'] }}" placeholder="Cari kode tes" class="input-appearance input-outline w-full">
          </div>
          @if (auth()->user()->current_role_id == 5)
            <button type="submit" class="btn btn-upbg-solid self-end text-sm sm:col-span-1 sm:col-start-2 sm:row-span-1 sm:row-start-4 lg:col-span-1 lg:col-start-3 lg:row-span-1 lg:row-start-3 xl:col-span-1 xl:col-start-4 xl:row-span-1 xl:row-start-2"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
            <button type="button" class="reset-filter btn btn-red-outline self-end text-sm sm:col-span-1 sm:col-start-1 sm:row-span-1 sm:row-start-4 lg:col-span-1 lg:col-start-2 lg:row-span-1 lg:row-start-3 xl:col-span-1 xl:col-start-3 xl:row-span-1 xl:row-start-2">Reset Filter</button>
          @else
            <button type="submit" class="btn btn-upbg-solid self-end text-sm sm:col-span-full sm:col-start-1 sm:row-span-1 sm:row-start-5 lg:col-span-1 lg:col-start-3 lg:row-span-1 lg:row-start-3 xl:col-span-1 xl:col-start-4 xl:row-span-1 xl:row-start-3"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
            <button type="button" class="reset-filter btn btn-red-outline self-end text-sm sm:col-span-1 sm:col-start-2 sm:row-span-1 sm:row-start-4 lg:col-span-1 lg:col-start-2 lg:row-span-1 lg:row-start-3 xl:col-span-1 xl:col-start-3 xl:row-span-1 xl:row-start-3">Reset Filter</button>
          @endif
        </div>
      </div>
    </form>
  </section>

  <section id="daftar-tes" class="flex flex-col lg:divide-y">
    <div class="hidden bg-white p-4 lg:grid lg:grid-cols-3 lg:gap-x-4">
      <p class="col-span-1 font-semibold tracking-wide text-gray-600">Kode Tes</p>
      <p class="col-span-1 font-semibold tracking-wide text-gray-600">Jadwal</p>
      <p class="col-span-1 font-semibold tracking-wide text-gray-600">Ruangan</p>
    </div>
    <div class="tes-container flex flex-col gap-3 lg:gap-0 lg:divide-y">
      @if ($tesList->isEmpty())
        <div class="tes-item grid grid-cols-1 gap-y-2 rounded-sm-md bg-white p-4 shadow-sm lg:grid-cols-3 lg:gap-x-4 lg:gap-y-0 lg:rounded-none">
          <p class="empty-query col-span-full">Tidak ada data yang cocok</p>
        </div>
      @else
        @foreach ($tesList as $tes)
          <div class="tes-item grid grid-cols-1 gap-y-2 rounded-sm-md bg-white p-4 shadow-sm lg:grid-cols-3 lg:gap-x-4 lg:gap-y-0 lg:rounded-none">
            <div class="flex flex-row items-center lg:col-span-1">
              <a href="{{ route('tes.detail', ['slug' => $tes->slug]) }}" class="truncate font-semibold text-upbg underline decoration-transparent transition hover:decoration-upbg">{{ $tes->kode }}</a>
            </div>
            <div class="flex flex-col justify-center lg:col-span-1">
              <div class="flex flex-col gap-2 text-gray-700">
                <p><i class="fa-solid fa-calendar-days mr-2"></i>{{ $tes->tanggal->isoFormat('dddd, D MMMM YYYY') }}</p>
                <p><i class="fa-regular fa-clock mr-2"></i>{{ $tes->waktu_mulai->isoFormat('HH:mm') }} - {{ $tes->waktu_selesai->isoFormat('HH:mm') }}</p>
              </div>
            </div>
            <div class="flex flex-wrap lg:col-span-1 lg:flex-col lg:justify-center lg:gap-1">
              @foreach ($tes->ruangan as $ruangan)
                {{-- blade-formatter-disable-next-line --}}
                <p class="text-gray-700"><i class="fa-regular fa-building mr-2 @if(!$loop->first) before:hidden lg:before:inline @endif"></i>{{ $ruangan->kode }}@if(!$loop->last)<span class="lg:hidden">, </span>@endif</p>
              @endforeach
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </section>
  {{ $tesList->onEachSide(2)->links() }}

  @pushOnce('script')
    <script src="{{ asset('js/views/tes/daftar-tes.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
