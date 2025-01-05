<x-layouts.user-layout>
  <x-slot:title>Daftar Level</x-slot>
  <div class="mb-8 mt-6 flex flex-row items-center justify-between gap-4">
    <h1 class="page-title">Daftar Level</h1>
    <button type="button" class="tambah-level btn btn-green-solid text-nowrap"><i class="fa-solid fa-plus mr-2"></i>Tambah Level</button>
  </div>

  <section id="daftar-level" class="mt-6 divide-y bg-white shadow-sm">
    <div class="grid grid-cols-12 items-center gap-x-4 py-4">
      <p class="col-span-2 pl-2 text-center font-semibold sm:col-span-1">No</p>
      <p class="col-span-5 font-semibold sm:col-span-4">Level</p>
      <p class="col-span-3 font-semibold">Kode</p>
      <p class="hidden text-center font-semibold sm:col-span-3 sm:block">Status</p>
    </div>
    @if ($levelList->isEmpty())
      <div class="rounded-sm-md bg-white p-4 shadow-sm lg:rounded-none lg:shadow-none">
        <p class="empty-query">Tidak ada data yang cocok</p>
      </div>
    @else
      @foreach ($levelList as $level)
        <div class="level-item grid grid-cols-12 items-center gap-x-4 py-5" data-level-id="{{ $level->id }}">
          <div class="col-span-2 pl-2 text-center font-medium sm:col-span-1">{{ $loop->iteration + ($levelList->currentPage() - 1) * $levelList->perPage() }}</div>
          <div class="nama-level col-span-5 sm:col-span-4">{{ $level->nama }}</div>
          <div class="kode-level col-span-3">{{ $level->kode }}</div>
          <div class="hidden sm:col-span-3 sm:flex sm:justify-center">
            @if ($level->aktif)
              <p class="status-level w-fit rounded-full bg-green-300 px-2 text-sm font-semibold text-green-800">Aktif</p>
            @else
              <p class="status-level w-fit rounded-full bg-red-300 px-2 text-sm font-semibold text-red-800">Tidak Aktif</p>
            @endif
          </div>
          <div class="relative col-span-2 text-center sm:col-span-1">
            <button type="button" class="btn-rounded btn-white menu border-none shadow-none"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            <x-ui.dialog class="right-1/2 top-full mt-1 translate-x-4">
              <button type="button" class="edit-level w-full px-2 py-1.5 text-left hover:bg-gray-100">Edit</button>
              <button type="button" class="delete-level w-full px-2 py-1.5 text-left text-red-600 hover:bg-gray-100">Delete</button>
            </x-ui.dialog>
          </div>
        </div>
      @endforeach
    @endif
  </section>
  {{ $levelList->onEachSide(2)->links() }}

  <x-ui.modal id="edit-level-modal">
    <form action="{{ route('level-kelas.update') }}" class="flex flex-col gap-3">
      <h1 class="modal-title mb-2">Edit Level</h1>
      <input type="hidden" name="level-id">
      <div class="input-group flex flex-col">
        <p class="input-label">Level</p>
        <input type="text" name="nama-level" placeholder="Nama level" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Kode</p>
        <input type="text" name="kode-level" placeholder="Kode level" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Status</p>
        <x-inputs.checkbox type="blue" inputName="status-level" value="1" class="status-level w-fit font-medium">Aktif</x-inputs.checkbox>
      </div>
      <hr>
      <div class="flex flex-row items-center justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn btn-upbg-solid">Simpan</button>
      </div>
    </form>
  </x-ui.modal>

  <x-ui.modal id="add-level-modal">
    <form action="{{ route('level-kelas.store') }}" class="flex flex-col gap-3">
      <h1 class="modal-title mb-2">Tambah Level</h1>
      <div class="input-group flex flex-col">
        <p class="input-label">Level</p>
        <input type="text" name="nama-level" placeholder="Nama level" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Kode</p>
        <input type="text" name="kode-level" placeholder="Kode level" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Status</p>
        <x-inputs.checkbox type="blue" inputName="status-level" value="1" class="status-level w-fit font-medium">Aktif</x-inputs.checkbox>
      </div>
      <hr>
      <div class="flex flex-row items-center justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn btn-green-solid">Tambah</button>
      </div>
    </form>
  </x-ui.modal>

  <x-ui.modal id="delete-level-modal">
    <form action="{{ route('level-kelas.destroy') }}" class="flex flex-col gap-5">
      <h1 class="modal-title">Hapus Level</h1>
      <p>Apakah anda yakin ingin menghapus level <span class="nama-kode-level font-semibold">Nama - kode</span> ?</p>
      <input type="hidden" name="level-id">
      <ul class="list-inside list-disc">
        <li>Data legacy dari level ini tetap bisa diakses</li>
        <li>Kode level yang sama tidak bisa digunakan untuk level lain</li>
      </ul>
      <div class="danger-container flex flex-col gap-2">
        <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
        <p>Hapus permanen akan menghapus level dari database dan semua data kelas yang terasosiasi dengan level ini!</p>
      </div>
      <div class="flex justify-center">
        <x-inputs.checkbox type="red" inputName="force-delete" value="1" class="w-fit font-medium">Hapus Permanen</x-inputs.checkbox>
      </div>
      <hr>
      <div class="flex flex-row items-center justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn btn-red-solid">Delete</button>
      </div>
    </form>
  </x-ui.modal>

  @pushOnce('script')
    <script src="{{ asset('js/views/kelas/level/daftar-level.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
