<x-layouts.user-layout>
  <x-slot:title>Daftar Peserta</x-slot>
  <div class="mb-8 mt-6 flex flex-row items-center justify-between gap-2">
    <h1 class="page-title">Daftar Peserta</h1>
  </div>

  <section id="filter-user">
    <form action="{{ route('peserta.index') }}" method="GET" class="filter-form grid grid-cols-1 gap-y-4 sm:grid-cols-[1fr_fit-content(100px)] sm:gap-x-2 sm:gap-y-0">
      <x-inputs.categorical-search.select :selected="$selected['categorical']" :search="$selected['search'] ?? ''">
        @foreach ($categoricalSearchOptions as $option)
          <x-inputs.categorical-search.option :name="$option['name']" :placeholder="$option['placeholder']" class="{{ $selected['categorical']['name'] == $option['name'] ? 'selected' : '' }}">{{ $option['text'] }}</x-inputs.categorical-search.option>
        @endforeach
      </x-inputs.categorical-search.select>
      <button type="submit" class="btn btn-upbg-solid"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
    </form>
  </section>

  <section id="daftar-peserta" class="mt-6 divide-y bg-white shadow-sm">
    <div class="grid grid-cols-12 items-center gap-x-4 py-4">
      <p class="col-span-2 pl-2 text-center font-semibold sm:col-span-1">No</p>
      <p class="col-span-10 font-semibold sm:col-span-6">Peserta</p>
      <p class="hidden font-semibold sm:col-span-5 sm:block sm:pr-2">Dept. / Occupation</p>
    </div>
    @foreach ($pesertaList as $peserta)
      <div class="user-item grid grid-cols-12 items-center gap-x-4 py-5">
        <div class="col-span-2 pl-2 text-center font-medium sm:col-span-1">{{ $loop->iteration + ($pesertaList->currentPage() - 1) * $pesertaList->perPage() }}</div>
        <div class="col-span-10 flex flex-col gap-1 sm:col-span-6">
          <a href="{{ route('peserta.detail', ['id' => $peserta->id]) }}" class="font-medium text-upbg transition hover:text-upbg-light">{{ $peserta->nama }}</a>
          <p class="truncate">{{ $peserta->nik }}</p>
          <p class="truncate sm:hidden">{{ $peserta->occupation }}</p>
        </div>
        <div class="hidden sm:col-span-5 sm:block sm:pr-2">
          <p class="truncate">{{ $peserta->occupation }}</p>
        </div>
      </div>
    @endforeach
  </section>

  {{ $pesertaList->onEachSide(2)->links() }}

  @pushOnce('script')
    <script src="{{ asset('js/views/peserta/daftar-peserta.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
