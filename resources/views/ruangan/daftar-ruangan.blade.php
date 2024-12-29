<x-layouts.user-layout>
  <x-slot:title>Daftar Ruangan</x-slot>
  <div class="mb-8 mt-6 flex flex-row items-center justify-between gap-4">
    <h1 class="page-title">Daftar Ruangan</h1>
    <button type="button" class="tambah-ruangan btn btn-green-solid text-nowrap"><i class="fa-solid fa-plus mr-2"></i>Tambah Ruangan</button>
  </div>

  <section id="daftar-ruangan" class="mt-6 divide-y bg-white shadow-sm">
    <div class="grid grid-cols-12 items-center gap-x-4 py-4">
      <p class="col-span-2 pl-2 text-center font-semibold sm:col-span-1">No</p>
      <p class="col-span-5 font-semibold">Ruangan</p>
      <p class="col-span-3 font-semibold sm:col-span-2">Kapasitas</p>
      <p class="hidden text-center font-semibold sm:col-span-3 sm:block">Status</p>
    </div>
    @foreach ($ruanganList as $ruangan)
      <div class="ruangan-item grid grid-cols-12 items-center gap-x-4 py-5" data-ruangan-id="{{ $ruangan->id }}">
        <div class="col-span-2 pl-2 text-center font-medium sm:col-span-1">{{ $loop->iteration + ($ruanganList->currentPage() - 1) * $ruanganList->perPage() }}</div>
        <div class="kode-ruangan col-span-5">{{ $ruangan->kode }}</div>
        <div class="kapasitas-ruangan col-span-3 sm:col-span-2">{{ $ruangan->kapasitas }}</div>
        <div class="hidden sm:col-span-3 sm:flex sm:justify-center">
          @if ($ruangan->status)
            <p class="status-ruangan w-fit rounded-full bg-green-300 px-2 text-sm font-semibold text-green-800">Aktif</p>
          @else
            <p class="status-ruangan w-fit rounded-full bg-red-300 px-2 text-sm font-semibold text-red-800">Tidak Aktif</p>
          @endif
        </div>
        <div class="relative col-span-2 text-center sm:col-span-1">
          <button type="button" class="btn-rounded btn-white menu border-none shadow-none"><i class="fa-solid fa-ellipsis-vertical"></i></button>
          <x-ui.dialog class="right-1/2 top-full mt-1 translate-x-4">
            <button type="button" class="edit-ruangan w-full px-2 py-1.5 text-left hover:bg-gray-100">Edit</button>
            <button type="button" class="delete-ruangan w-full px-2 py-1.5 text-left text-red-600 hover:bg-gray-100">Delete</button>
          </x-ui.dialog>
        </div>
      </div>
    @endforeach
  </section>
  {{ $ruanganList->onEachSide(2)->links() }}

  <x-ui.modal id="edit-ruangan-modal">
    <form action="{{ route('ruangan.update') }}" class="flex flex-col gap-3">
      <h1 class="modal-title mb-2">Edit Ruangan</h1>
      <input type="hidden" name="ruangan-id">
      <div class="input-group flex flex-col">
        <p class="input-label">Ruangan</p>
        <input type="text" name="kode-ruangan" placeholder="Kode ruangan" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Kapasitas</p>
        <input type="number" name="kapasitas-ruangan" placeholder="Kapasitas ruangan" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Status</p>
        <x-inputs.checkbox type="blue" inputName="status-ruangan" value="1" class="status-ruangan w-fit font-medium">Aktif</x-inputs.checkbox>
      </div>
      <hr>
      <div class="flex flex-row items-center justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn btn-upbg-solid">Simpan</button>
      </div>
    </form>
  </x-ui.modal>

  <x-ui.modal id="add-ruangan-modal">
    <form action="{{ route('ruangan.store') }}" class="flex flex-col gap-3">
      <h1 class="modal-title mb-2">Tambah Ruangan</h1>
      <div class="input-group flex flex-col">
        <p class="input-label">Ruangan</p>
        <input type="text" name="kode-ruangan" placeholder="Kode ruangan" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Kapasitas</p>
        <input type="number" name="kapasitas-ruangan" placeholder="Kapasitas ruangan" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Status</p>
        <x-inputs.checkbox type="blue" inputName="status-ruangan" value="1" class="status-ruangan w-fit font-medium">Aktif</x-inputs.checkbox>
      </div>
      <hr>
      <div class="flex flex-row items-center justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn btn-green-solid">Tambah</button>
      </div>
    </form>
  </x-ui.modal>

  <x-ui.modal id="delete-ruangan-modal">
    <form action="{{ route('ruangan.destroy') }}" class="flex flex-col gap-5">
      <h1 class="modal-title">Hapus Ruangan</h1>
      <p>Apakah anda yakin ingin menghapus ruangan <span class="kode-ruangan font-semibold">Kode</span> ?</p>
      <input type="hidden" name="ruangan-id">
      <ul class="list-inside list-disc">
        <li>Data legacy dari ruangan ini (Kelas dan Tes) tetap bisa diakses</li>
        <li>Kode ruangan yang sama tidak bisa digunakan untuk ruangan lain</li>
      </ul>
      <div class="danger-container flex flex-col gap-2">
        <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
        <p>Hapus permanen akan menghapus ruangan dari database dan semua data <span class="font-semibold">Kelas</span> dan <span class="font-semibold">Tes</span> yang terasosiasi dengan kelas ini!</p>
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
    <script src="{{ asset('js/views/ruangan/daftar-ruangan.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
