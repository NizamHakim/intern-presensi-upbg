<section id="file-peserta-section" class="flex min-w-0 flex-col gap-2">
  <h1 class="mb-2 font-medium text-gray-700">Peserta @if (!$required)
      (opsional)
    @endif
  </h1>
  <div class="mb-2 flex flex-row items-center gap-6">
    <label id="excel-csv-label" for="excel-csv" class="btn btn-white cursor-pointer text-nowrap"><i class="fa-solid fa-file mr-2"></i>Pilih file</label>
    <input id="excel-csv" name="input-excel-csv" type="file" class="hidden" accept=".xlsx,.csv">
    <div class="panduan-penggunaan flex cursor-pointer flex-row items-center gap-2 text-upbg transition hover:text-upbg-light">
      <i class="fa-solid fa-circle-info text-base"></i>
      <span class="text-xs">Panduan penggunaan</span>
    </div>
  </div>
  <div class="peserta-container flex min-w-0 flex-col gap-3">
    <div class="peserta-item-placeholder flex h-14 flex-col items-center justify-center rounded-md border border-dashed border-gray-400 text-gray-400">
      Tambah peserta
    </div>
  </div>
  <div class="mt-1 flex w-full flex-row items-center justify-center gap-4">
    <button type="button" class="tambah-peserta btn-rounded btn-white hover:bg-gray-200"><i class="fa-solid fa-plus text-lg"></i></button>
  </div>
</section>

<x-ui.modal id="panduan-penggunaan-modal">
  <div class="flex flex-col gap-4">
    <h1 class="modal-title">Panduan Penggunaan</h1>
    <hr class="w-full">
    <ul class="list-outside list-disc pl-4">
      <li>Dapat menggunakan file dengan extension .xlsx atau .csv</li>
      <li>File harus memiliki header dengan nama <span class="font-semibold text-upbg">NIK/NRP</span>, <span class="font-semibold text-upbg">Nama</span>, dan <span class="font-semibold text-upbg">Dept./Occupation</span></li>
    </ul>

    <div class="grid grid-cols-1 divide-y border">
      <div class="grid grid-cols-3 divide-x">
        <div class="truncate px-2 py-3 font-bold">NIK/NRP</div>
        <div class="truncate px-2 py-3 font-bold">Nama</div>
        <div class="truncate px-2 py-3 font-bold">Dept./Occupation</div>
      </div>

      <div class="grid grid-cols-3 divide-x">
        <div class="truncate px-2 py-3">5822305823</div>
        <div class="truncate px-2 py-3">Kevin</div>
        <div class="truncate px-2 py-3">Teknik Biomedis</div>
      </div>

      <div class="grid grid-cols-3 divide-x">
        <div class="truncate px-2 py-3">2182943812</div>
        <div class="truncate px-2 py-3">Steven</div>
        <div class="truncate px-2 py-3">Desain Komunikasi Visual</div>
      </div>

      <div class="grid grid-cols-3 divide-x">
        <div class="truncate px-2 py-3">2394350238</div>
        <div class="truncate px-2 py-3">Jane</div>
        <div class="truncate px-2 py-3">Teknik Industri</div>
      </div>

      <div class="grid grid-cols-3 divide-x">
        <div class="truncate px-2 py-3">1282359452</div>
        <div class="truncate px-2 py-3">John</div>
        <div class="truncate px-2 py-3">Teknik Perkapalan</div>
      </div>
    </div>
    <a href="{{ asset('files/template-input-peserta.xlsx') }}" class="btn btn-white"><i class="fa-solid fa-file-arrow-down mr-2"></i>Download Template</a>
    <button type="button" class="cancel-button btn btn-white border-none shadow-none">Tutup</button>
  </div>
</x-ui.modal>

@pushOnce('components-supports')
  <x-ui.modal id="add-edit-peserta-modal">
    <form class="flex flex-col gap-4">
      <div class="input-group">
        <p class="input-label">NIK / NRP</p>
        <input type="text" name="nik-peserta" placeholder="NIK / NRP" class="input-appearance input-outline w-full" required>
      </div>
      <div class="input-group">
        <p class="input-label">Nama</p>
        <input type="text" name="nama-peserta" placeholder="Nama" class="input-appearance input-outline w-full" required>
      </div>
      <div class="input-group">
        <p class="input-label">Departemen / Occupation</p>
        <input type="text" name="occupation-peserta" placeholder="Departemen / Occupation" class="input-appearance input-outline w-full" required>
      </div>
      <div class="flex flex-row justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn"></button>
      </div>
    </form>
  </x-ui.modal>
@endPushOnce

@pushOnce('script')
  <script src="{{ asset('js/views/components/ui/dialog.js') }}"></script>
  <script src="{{ asset('js/views/components/ui/file-peserta.js') }}"></script>
@endPushOnce
