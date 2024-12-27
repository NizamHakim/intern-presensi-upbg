<x-layouts.user-layout>
  <x-slot:title>Daftar Program</x-slot>
  <div class="mb-8 mt-6 flex flex-row items-center justify-between gap-4">
    <h1 class="page-title">Daftar Program</h1>
    <button type="button" class="tambah-program btn btn-green-solid"><i class="fa-solid fa-plus mr-2"></i>Tambah Program</button>
  </div>

  <section id="daftar-program" class="mt-6 divide-y bg-white shadow-sm">
    <div class="grid grid-cols-12 items-center gap-x-4 py-4">
      <p class="col-span-1 pl-2 text-center font-semibold">No</p>
      <p class="col-span-4 font-semibold">Program</p>
      <p class="col-span-3 font-semibold">Kode</p>
      <p class="col-span-3 text-center font-semibold">Status</p>
    </div>
    @foreach ($programList as $program)
      <div class="program-item grid grid-cols-12 items-center gap-x-4 py-5" data-program-id="{{ $program->id }}">
        <div class="col-span-1 pl-2 text-center font-medium">{{ $loop->iteration }}.</div>
        <div class="nama-program col-span-4">{{ $program->nama }}</div>
        <div class="kode-program col-span-3">{{ $program->kode }}</div>
        <div class="col-span-3 flex justify-center">
          @if ($program->aktif)
            <p class="status-program w-fit rounded-full bg-green-300 px-2 text-sm font-semibold text-green-800">Aktif</p>
          @else
            <p class="status-program w-fit rounded-full bg-red-300 px-2 text-sm font-semibold text-red-800">Tidak Aktif</p>
          @endif
        </div>
        <div class="relative col-span-1 text-center">
          <button type="button" class="btn-rounded btn-white menu border-none shadow-none"><i class="fa-solid fa-ellipsis-vertical"></i></button>
          <x-ui.dialog class="right-1/2 top-full mt-1 translate-x-4">
            <button type="button" class="edit-program w-full px-2 py-1.5 text-left hover:bg-gray-100">Edit</button>
            <button type="button" class="delete-program w-full px-2 py-1.5 text-left text-red-600 hover:bg-gray-100">Delete</button>
          </x-ui.dialog>
        </div>
      </div>
    @endforeach
    {{ $programList->onEachSide(2)->links() }}
  </section>

  <x-ui.modal id="edit-program-modal">
    <form action="{{ route('program-kelas.update') }}" class="flex flex-col gap-3">
      <h1 class="modal-title mb-2">Edit Program</h1>
      <input type="hidden" name="program-id">
      <div class="input-group flex flex-col">
        <p class="input-label">Program</p>
        <input type="text" name="nama-program" placeholder="Nama program" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Kode</p>
        <input type="text" name="kode-program" placeholder="Kode program" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Status</p>
        <x-inputs.checkbox type="blue" inputName="status-program" value="1" class="status-program w-fit font-medium">Aktif</x-inputs.checkbox>
      </div>
      <hr>
      <div class="flex flex-row items-center justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn btn-upbg-solid">Simpan</button>
      </div>
    </form>
  </x-ui.modal>

  <x-ui.modal id="add-program-modal">
    <form action="{{ route('program-kelas.store') }}" class="flex flex-col gap-3">
      <h1 class="modal-title mb-2">Tambah Program</h1>
      <div class="input-group flex flex-col">
        <p class="input-label">Program</p>
        <input type="text" name="nama-program" placeholder="Nama program" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Kode</p>
        <input type="text" name="kode-program" placeholder="Kode program" class="input-appearance input-outline">
      </div>
      <div class="input-group flex flex-col">
        <p class="input-label">Status</p>
        <x-inputs.checkbox type="blue" inputName="status-program" value="1" class="status-program w-fit font-medium">Aktif</x-inputs.checkbox>
      </div>
      <hr>
      <div class="flex flex-row items-center justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn btn-green-solid">Tambah</button>
      </div>
    </form>
  </x-ui.modal>

  <x-ui.modal id="delete-program-modal">
    <form action="{{ route('program-kelas.destroy') }}" class="flex flex-col gap-5">
      <h1 class="modal-title">Hapus Program</h1>
      <p>Apakah anda yakin ingin menghapus program <span class="nama-kode-program font-semibold">Nama - kode</span> ?</p>
      <input type="hidden" name="program-id">
      <ul class="list-inside list-disc">
        <li>Data legacy dari program ini tetap bisa diakses</li>
        <li>Kode program yang sama tidak bisa digunakan untuk program lain</li>
      </ul>
      <div class="danger-container flex flex-col gap-2">
        <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
        <p>Hapus permanen akan menghapus program dari database dan semua data kelas yang terasosiasi dengan program ini!</p>
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
    <script src="{{ asset('js/views/kelas/program/daftar-program.js') }}"></script>
  @endPushOnce
</x-layouts.user-layout>
