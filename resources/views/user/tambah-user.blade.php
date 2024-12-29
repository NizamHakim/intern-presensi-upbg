<x-layouts.user-layout>
  <x-slot:title>Tambah User</x-slot>
  <div class="mb-8 mt-6 flex flex-col gap-6">
    <h1 class="page-title">Tambah User</h1>
    <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
  </div>

  <section id="tambah-user" class="mt-6 flex min-w-0 flex-col bg-white p-6 shadow-sm">
    <form action="{{ route('user.store') }}" class="tambah-user-form">
      <div class="input-group mt-4 flex flex-col">
        <p class="input-label">NIK / NIP</p>
        <input type="number" name="nik" class="input-appearance input-outline" placeholder="NIK / NIP">
      </div>
      <div class="input-group mt-4 flex flex-col">
        <p class="input-label">Nama Lengkap</p>
        <input type="text" name="nama" class="input-appearance input-outline" placeholder="Nama lengkap">
      </div>
      <div class="input-group mt-4 flex flex-col">
        <p class="input-label">Nama Panggilan</p>
        <input type="text" name="nama-panggilan" class="input-appearance input-outline" placeholder="Nama panggilan">
      </div>
      <div class="input-group mt-4 flex flex-col">
        <p class="input-label">Nomor HP</p>
        <input type="text" name="nomor-hp" class="input-appearance input-outline" placeholder="Nomor HP">
      </div>
      <hr class="my-5">
      <div class="input-group flex flex-col">
        <p class="input-label">Email</p>
        <input type="email" name="email" class="input-appearance input-outline" placeholder="Email">
      </div>
      <div class="mt-4 grid grid-flow-row grid-cols-1 items-start gap-x-2 gap-y-4 sm:grid-cols-2 sm:gap-y-0">
        <div class="input-group flex flex-col">
          <p class="input-label">Password</p>
          <input type="password" name="password" class="input-appearance input-outline input-readonly" placeholder="Password">
        </div>
        <div class="input-group flex flex-col">
          <p class="input-label">Konfirmasi Password</p>
          <input type="password" name="konfirmasi-password" class="input-appearance input-outline input-readonly" placeholder="Konfirmasi Password">
        </div>
        <x-inputs.checkbox type="blue" inputName="toggle-password-nik" value="1" class="sm:mt-4 sm:w-fit">Gunakan NIK / NIP sebagai password</x-inputs.checkbox>
      </div>
      <hr class="my-5">
      <p class="input-label mb-2">Role</p>
      <div class="input-group flex flex-col gap-2 sm:flex-row">
        @foreach ($roleOptions as $role)
          <x-inputs.checkbox type="blue" inputName="role" class="sm:w-fit" :value="$role->id">{{ $role->nama }}</x-inputs.checkbox>
        @endforeach
      </div>
      <hr class="my-5">
      <div class="flex flex-row justify-end gap-2">
        <a href="{{ route('user.index') }}" class="btn btn-white border-none shadow-none">Cancel</a>
        <button type="submit" class="btn btn-green-solid">Tambah</button>
      </div>
    </form>
  </section>

  @push('script')
    <script src="{{ asset('js/views/user/tambah-user.js') }}"></script>
  @endpush
</x-layouts.user-layout>
