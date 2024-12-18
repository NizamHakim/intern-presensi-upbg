<section id="pengajar-section" class="flex flex-col gap-2">
    <h1 class="input-label">Pengajar</h1>
    <div class="pengajar-container flex flex-col gap-3">
        @if ($kelas)
            @foreach ($kelas->pengajar as $pengajar)
                <div class="pengajar-item flex flex-row gap-3  @if($loop->first) md:mr-[3.25rem] @endif">
                    <div class="input-group flex-1">
                        <x-inputs.dropdown.select name="pengajar" placeholder="Pilih pengajar" :selected="['text' => $pengajar->nama . ' (' . $pengajar->nik . ')', 'value' => $pengajar->id ]" class="pengajar-dropdown">
                            @foreach ($pengajarOptions as $option)
                                <x-inputs.dropdown.option :value="$option->id" class="{{ ($option->id == $pengajar->id) ? 'selected' : '' }}">{{ "$option->nama ($option->nik)" }}</x-inputs.dropdown.option>
                            @endforeach
                        </x-inputs.dropdown.select>
                    </div>
                    @if (!$loop->first)
                        <button type="button" class="delete-pengajar font-medium text-red-600 bg-white border shadow-sm size-10 rounded-full transition hover:bg-red-600 hover:text-white hover:border-red-600"><i class="fa-regular fa-trash-can"></i></button>               
                    @endif 
                </div>
            @endforeach
        @else
            <div class="pengajar-item flex flex-row gap-3 md:mr-[3.25rem]">
                <div class="input-group flex-1">
                    <x-inputs.dropdown.select name="pengajar" placeholder="Pilih pengajar" class="pengajar-dropdown">
                        @foreach ($pengajarOptions as $option)
                            <x-inputs.dropdown.option :value="$option->id">{{ "$option->nama ($option->nik)" }}</x-inputs.dropdown.option>
                        @endforeach
                    </x-inputs.dropdown.select>
                </div>
            </div>
        @endif
    </div>
    <div class="w-full flex flex-row justify-center items-center gap-4 mt-1">
        <button type="button" class="tambah-pengajar font-medium text-gray-600 size-10 border shadow-sm rounded-full text-lg transition hover:text-white hover:bg-green-600 hover:border-green-600"><i class="fa-solid fa-plus"></i></button>
    </div>
</section>

@pushOnce('script')
    <script src="{{ asset('js/views/components/kelas/pengajar-dynamic.js') }}"></script>
@endPushOnce