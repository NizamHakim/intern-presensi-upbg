<x-layouts.user-layout>
  <x-slot:title>{{ $user->nama }}</x-slot>
  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Detail User</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <section id="detail-user" class="bg-white p-6 shadow-sm md:p-12">
    <div class="flex flex-col gap-8 md:flex-row md:gap-20">
      <img src="{{ $user->profile_picture }}" class="size-44 self-center rounded-sm-md shadow-sm md:size-52 md:self-start">
      <div class="flex w-full flex-col">
        <div class="grid grid-cols-1 gap-y-3 md:grid-cols-2">
          <div class="flex flex-col gap-1 md:col-span-1 md:col-start-1">
            <p class="font-medium">NIK / NIP</p>
            <p class="text-wrap">{{ $user->nik }}</p>
          </div>
          <div class="flex flex-col gap-1 md:row-span-1 md:row-start-2">
            <p class="font-medium">Nama Lengkap</p>
            <p class="text-wrap">{{ $user->nama }}</p>
          </div>
          <div class="flex flex-col gap-1">
            <p class="font-medium">No. HP</p>
            <a href="{{ 'http://wa.me/62' . substr($user->no_hp, 1) }}" target="_blank" class="w-fit text-wrap text-upbg underline decoration-transparent transition hover:text-upbg-light hover:decoration-upbg-light">{{ $user->no_hp }}</a>
          </div>
          <div class="flex flex-col gap-1">
            <p class="font-medium">Email</p>
            <a href="mailto:{{ $user->email }}" class="w-fit text-wrap text-upbg underline decoration-transparent transition hover:text-upbg-light hover:decoration-upbg-light">{{ $user->email }}</a>
          </div>
        </div>
        <hr class="my-5 w-full">
        <form action="{{ route('user.updateRole', ['id' => $user->id]) }}" class="update-role-form">
          <p class="mb-3 font-medium">Role</p>
          <div class="role-container flex flex-col gap-3 sm:flex-row">
            @foreach ($roleOptions as $role)
              <x-inputs.checkbox type="blue" inputName="role" class="sm:w-fit" :value="$role->id" :checked="$user->roles->contains('id', $role->id)">
                {{ $role->nama }}
              </x-inputs.checkbox>
            @endforeach
          </div>
        </form>
      </div>
    </div>
  </section>

  <section id="history-kelas" class="mt-8 flex flex-col bg-white p-6 shadow-sm">
    <x-inputs.date inputName="tanggal" placeholder="Semua" plugin="month" />
    <h1 class="mb-2 mt-4 font-semibold">Histori Kelas</h1>
    <div class="grid grid-cols-1 divide-y border">
      <div class="grid grid-cols-12 divide-x">
        <p class="col-span-2 px-2 py-2 text-center font-medium sm:col-span-1">No</p>
        <p class="col-span-10 px-4 py-2 font-medium sm:col-span-11">Kode Kelas</p>
      </div>
      @if ($user->mengajarKelas->isEmpty())
        <p class="py-4 text-center font-medium">Tidak ada data yang cocok</p>
      @else
        @foreach ($user->mengajarKelas as $kelas)
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
      @if ($user->mengawasiTes->isEmpty())
        <p class="py-4 text-center font-medium">Tidak ada data yang cocok</p>
      @else
        @foreach ($user->mengawasiTes as $tes)
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
    <script src="{{ asset('js/views/user/detail-user.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
