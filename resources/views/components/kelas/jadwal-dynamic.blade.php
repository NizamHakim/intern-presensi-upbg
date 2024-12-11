<section id="jadwal-section" class="flex flex-col gap-2">
    <h1 class="input-label">Jadwal</h1>
    <p class="font-medium p-4 text-upbg bg-blue-100 rounded-sm-md">Jadwal pertemuan yang sudah dibuat tidak akan otomatis diubah</p>

    <div class="jadwal-container flex flex-col gap-3">
        @foreach ($kelas->jadwal as $jadwal)
            <div class="jadwal-item flex flex-row items-center border shadow-sm rounded-md md:border-none md:shadow-none md:items-start">
                <div class="input-container flex flex-row items-center flex-1 pl-3 py-2 gap-2 md:p-0 md:items-start @if($loop->first) md:mr-[3.25rem] @endif">
                    <div class="input-group md:flex-1">
                        <x-inputs.dropdown.select name="hari" placeholder="Pilih hari" :selected="['text' => $jadwal->namaHari, 'value' => $jadwal->hari]" class="hari-dropdown hidden md:block">
                            @foreach ($hariOptions as $hari)
                                <x-inputs.dropdown.option :value="$hari['value']" class="{{ ($hari['value'] == $jadwal->hari) ? 'selected' : '' }}">{{ $hari['text'] }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                        <p class="text-gray-700 md:hidden"><i class="fa-solid fa-calendar-days mr-2"></i><span class="hari-mobile">{{ $jadwal->namaHari }}</span></p>
                    </div>
                    <div class="flex flex-row items-center gap-2 md:flex-2 md:items-start">
                        <div class="input-group min-w-0 md:flex-1">
                            <x-inputs.time inputName="waktu-mulai" :value="$jadwal->waktu_mulai" placeholder="Waktu mulai" class="waktu-mulai hidden md:block"></x-inputs.time>
                            <p class="waktu-mulai-mobile text-gray-700 md:hidden">{{ $jadwal->waktu_mulai->isoFormat("HH:mm") }}</p>
                        </div>
                        <span class="text-gray-700 text-lg md:mt-2">-</span>
                        <div class="input-group min-w-0 md:flex-1">
                            <x-inputs.time inputName="waktu-selesai" :value="$jadwal->waktu_selesai" placeholder="Waktu selesai" class="waktu-selesai hidden md:block"></x-inputs.time>
                            <p class="waktu-selesai-mobile text-gray-700 md:hidden">{{ $jadwal->waktu_selesai->isoFormat("HH:mm") }}</p>
                        </div>
                    </div>
                </div>
                <div class="jadwal-buttons flex flex-row items-center h-fit md:items-start @if (!$loop->first) md:ml-3 @endif">
                    <button type="button" class="edit-jadwal font-medium text-upbg bg-white size-8 rounded-sm-md transition md:hidden"><i class="fa-regular fa-pen-to-square"></i></button>
                    @if (!$loop->first)
                        <button type="button" class="delete-jadwal font-medium text-red-600 bg-white size-8 rounded-sm-md transition md:hover:bg-red-600 md:hover:text-white md:hover:border-red-600 md:size-10 md:rounded-full md:border"><i class="fa-regular fa-trash-can"></i></button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex flex-row items-center gap-4 mt-1">
        <hr class="flex-1">
        <button type="button" class="tambah-jadwal font-medium text-gray-600 size-10 border rounded-full text-lg transition hover:text-white hover:bg-green-600 hover:border-green-600"><i class="fa-solid fa-plus"></i></button>
        <hr class="flex-1">
    </div>
</section>

@pushOnce('script')
    <script src="{{ asset('js/views/components/kelas/jadwal-dynamic.js') }}"></script>
@endPushOnce

{{-- require add-edit-jadwal-modal for mobile support --}}