<x-layouts.user-layout>
  <x-slot:title>Daftar User</x-slot>
  <div class="mb-8 mt-6 flex flex-row items-center justify-between gap-2">
    <h1 class="page-title">Daftar User</h1>
    @if (auth()->user()->current_role_id == 2)
      <a href="{{ route('user.create') }}" class="btn btn-green-solid"><i class="fa-solid fa-plus mr-2"></i>Tambah User</a>
    @endif
  </div>

  <section id="filter-user">
    <form action="{{ route('user.index') }}" method="GET" class="filter-form grid grid-cols-1 gap-y-4 sm:grid-cols-[1fr_fit-content(100px)] sm:gap-x-2 sm:gap-y-0">
      <x-inputs.categorical-search.select :selected="$selected['categorical']" :search="$selected['search'] ?? ''">
        @foreach ($categoricalSearchOptions as $option)
          <x-inputs.categorical-search.option :name="$option['name']" :placeholder="$option['placeholder']" class="{{ $selected['categorical']['name'] == $option['name'] ? 'selected' : '' }}">{{ $option['text'] }}</x-inputs.categorical-search.option>
        @endforeach
      </x-inputs.categorical-search.select>
      <button type="submit" class="btn btn-upbg-solid"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
    </form>
  </section>

  <section id="daftar-user" class="mt-6 divide-y bg-white shadow-sm">
    <div class="grid grid-cols-12 items-center gap-x-4 py-4">
      <p class="col-span-2 pl-2 text-center font-semibold sm:col-span-1">No</p>
      <p class="col-span-10 font-semibold sm:col-span-11">User</p>
    </div>
    @foreach ($usersList as $user)
      <div class="user-item grid grid-cols-12 items-center gap-x-4 py-5">
        <div class="col-span-2 pl-2 text-center font-medium sm:col-span-1">{{ $loop->iteration + ($usersList->currentPage() - 1) * $usersList->perPage() }}</div>
        <div class="col-span-10 flex items-center gap-6 sm:col-span-11">
          <img src="{{ $user->profile_picture }}" class="size-12 rounded-sm-md shadow-sm md:size-16">
          <div class="flex flex-col">
            <a href="{{ route('user.detail', ['id' => $user->id]) }}" class="font-medium text-upbg transition hover:text-upbg-light">{{ $user->nama }}</a>
            <p class="text-gray-600">{{ $user->nik }}</p>
          </div>
        </div>
      </div>
    @endforeach
  </section>

  {{ $usersList->onEachSide(2)->links() }}

  @pushOnce('script')
    <script src="{{ asset('js/views/user/daftar-user.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
