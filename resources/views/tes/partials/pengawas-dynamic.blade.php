<section id="pengawas-section" class="flex flex-col gap-2">
  <h1 class="input-label">Pengawas</h1>
  <div class="pengawas-container flex flex-col gap-3">
    @if ($tes)
      @foreach ($tes->pengawas as $pengawas)
        <div class="pengawas-item @if ($loop->first) mr-11 @endif grid grid-flow-col grid-cols-1">
          <div class="input-group">
            <x-inputs.dropdown.select name="pengawas" placeholder="Pilih pengawas" :selected="['text' => $pengawas->nama . ' (' . $pengawas->nik . ')', 'value' => $pengawas->id]" class="pengawas-dropdown">
              @foreach ($pengawasOptions as $option)
                <x-inputs.dropdown.option :value="$option->id" class="{{ $option->id == $pengawas->id ? 'selected' : '' }}">{{ "$option->nama ($option->nik)" }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          @if (!$loop->first)
            <button type="button" class="delete-pengawas btn-rounded btn-white ml-2 text-red-600"><i class="fa-regular fa-trash-can"></i></button>
          @endif
        </div>
      @endforeach
    @else
      <div class="pengawas-item mr-11 grid grid-flow-col grid-cols-1">
        <div class="input-group">
          <x-inputs.dropdown.select name="pengawas" placeholder="Pilih pengawas" class="pengawas-dropdown">
            @foreach ($pengawasOptions as $option)
              <x-inputs.dropdown.option :value="$option->id">{{ "$option->nama ($option->nik)" }}</x-inputs.dropdown.option>
            @endforeach
          </x-inputs.dropdown.select>
        </div>
      </div>
    @endif
    <template id="template-pengawas">
      <div class="pengawas-item grid grid-flow-col grid-cols-1">
        <div class="input-group">
          <x-inputs.dropdown.select name="pengawas" placeholder="Pilih pengawas" class="pengawas-dropdown">
            @foreach ($pengawasOptions as $option)
              <x-inputs.dropdown.option :value="$option->id">{{ "$option->nama ($option->nik)" }}</x-inputs.dropdown.option>
            @endforeach
          </x-inputs.dropdown.select>
        </div>
        <button type="button" class="delete-pengawas btn-rounded btn-white ml-2 text-red-600"><i class="fa-regular fa-trash-can"></i></button>
      </div>
    </template>
  </div>
  <div class="mt-1 flex w-full flex-row items-center justify-center gap-4">
    <button type="button" class="tambah-pengawas btn-rounded btn-white hover:bg-gray-200"><i class="fa-solid fa-plus text-lg"></i></button>
  </div>
</section>

@pushOnce('script')
  <script src="{{ asset('js/views/tes/partials/pengawas-dynamic.js') }}"></script>
@endPushOnce
