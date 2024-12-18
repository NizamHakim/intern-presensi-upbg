<section id="file-peserta-section" class="flex flex-col gap-2">
    <h1 class="text-gray-700 font-medium mb-2">Peserta</h1>
    <div class="flex flex-row items-center gap-6 mb-2">
        <label id="excel-csv-label" for="excel-csv" class="button-style text-gray-700 text-nowrap cursor-pointer hover:bg-gray-100"><i class="fa-solid fa-file mr-2"></i>Pilih file</label>
        <input id="excel-csv" name="input-excel-csv" type="file" class="hidden" accept=".xlsx,.csv">
        <div class="panduan-penggunaan flex flex-row items-center gap-2 text-upbg cursor-pointer">
            <i class="fa-solid fa-circle-info text-base"></i>
            <span class="text-xs">Panduan penggunaan</span>
        </div>
    </div>
    <div class="peserta-container flex flex-col gap-3">
        <div class="peserta-item-placeholder flex flex-col justify-center items-center text-gray-400 h-14 border border-dashed border-gray-400 rounded-md">
            Tambah peserta
        </div>
    </div>
    <div class="w-full flex flex-row justify-center items-center gap-4 mt-1">
        <button type="button" class="tambah-peserta font-medium text-gray-600 size-10 border shadow-sm rounded-full text-lg transition hover:text-white hover:bg-green-600 hover:border-green-600"><i class="fa-solid fa-plus"></i></button>
    </div>
</section>

<x-ui.modal id="panduan-penggunaan-modal">
    <div class="flex flex-col gap-4">
        <h1 class="modal-title">Panduan Penggunaan</h1>
        <hr class="w-full">
        <ul class="list-inside list-disc">
            <li>Dapat menggunakan file dengan extension .xlsx atau .csv</li>
            <li>File harus memiliki header dengan nama <span class="font-semibold text-upbg">NIK/NRP</span>, <span class="font-semibold text-upbg">Nama</span>, dan <span class="font-semibold text-upbg">Dept./Occupation</span></li>
        </ul>

        <p class="font-medium">Contoh file</p>
        
        <div class="grid grid-cols-1 border divide-y">
            <div class="grid grid-cols-3 divide-x">
                <div class="px-2 py-3 font-bold truncate">NIK/NRP</div>
                <div class="px-2 py-3 font-bold truncate">Nama</div>
                <div class="px-2 py-3 font-bold truncate">Dept./Occupation</div>
            </div>
            
            <div class="grid grid-cols-3 divide-x">
                <div class="px-2 py-3 truncate">5822305823ssss</div>
                <div class="px-2 py-3 truncate">Kevin</div>
                <div class="px-2 py-3 truncate">Teknik Biomedis</div>
            </div>
        
            <div class="grid grid-cols-3 divide-x">
                <div class="px-2 py-3 truncate">2182943812</div>
                <div class="px-2 py-3 truncate">Steven</div>
                <div class="px-2 py-3 truncate">Desain Komunikasi Visual</div>
            </div>
        
            <div class="grid grid-cols-3 divide-x">
                <div class="px-2 py-3 truncate">2394350238</div>
                <div class="px-2 py-3 truncate">Jane</div>
                <div class="px-2 py-3 truncate">Teknik Industri</div>
            </div>
        
            <div class="grid grid-cols-3 divide-x">
                <div class="px-2 py-3 truncate">1282359452</div>
                <div class="px-2 py-3 truncate">John</div>
                <div class="px-2 py-3 truncate">Teknik Perkapalan</div>
            </div>
        </div>
        
        <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Tutup</button>
    </div>
</x-ui.modal>

@pushOnce('script')
    <script src="{{ asset('js/views/components/ui/file-peserta.js') }}"></script>
@endPushOnce