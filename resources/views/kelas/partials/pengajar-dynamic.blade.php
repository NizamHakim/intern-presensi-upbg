<section id="pengajar-section" class="flex flex-col gap-2">
  <h1 class="input-label">Pengajar</h1>
  <div class="pengajar-container flex flex-col gap-3">
    @if ($kelas)
      @foreach ($kelas->pengajar as $pengajar)
        <div class="pengajar-item @if ($loop->first) mr-11 @endif grid grid-flow-col grid-cols-1">
          <div class="input-group">
            <x-inputs.dropdown.select name="pengajar" placeholder="Pilih pengajar" :selected="['text' => $pengajar->nama . ' (' . $pengajar->nik . ')', 'value' => $pengajar->id]" class="pengajar-dropdown">
              @foreach ($pengajarOptions as $option)
                <x-inputs.dropdown.option :value="$option->id" class="{{ $option->id == $pengajar->id ? 'selected' : '' }}">{{ "$option->nama ($option->nik)" }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          @if (!$loop->first)
            <button type="button" class="delete-pengajar btn-rounded btn-white ml-2 text-red-600"><i class="fa-regular fa-trash-can"></i></button>
          @endif
        </div>
      @endforeach
    @else
      <div class="pengajar-item mr-11 grid grid-flow-col grid-cols-1">
        <div class="input-group">
          <x-inputs.dropdown.select name="pengajar" placeholder="Pilih pengajar" class="pengajar-dropdown">
            @foreach ($pengajarOptions as $option)
              <x-inputs.dropdown.option :value="$option->id">{{ "$option->nama ($option->nik)" }}</x-inputs.dropdown.option>
            @endforeach
          </x-inputs.dropdown.select>
        </div>
      </div>
    @endif
    <template id="template-pengajar">
      <div class="pengajar-item grid grid-flow-col grid-cols-1">
        <div class="input-group">
          <x-inputs.dropdown.select name="pengajar" placeholder="Pilih pengajar" class="pengajar-dropdown">
            @foreach ($pengajarOptions as $option)
              <x-inputs.dropdown.option :value="$option->id">{{ "$option->nama ($option->nik)" }}</x-inputs.dropdown.option>
            @endforeach
          </x-inputs.dropdown.select>
        </div>
        <button type="button" class="delete-pengajar btn-rounded btn-white ml-2 text-red-600"><i class="fa-regular fa-trash-can"></i></button>
      </div>
    </template>
  </div>
  <div class="mt-1 flex w-full flex-row items-center justify-center gap-4">
    <button type="button" class="tambah-pengajar btn-rounded btn-white hover:bg-gray-200"><i class="fa-solid fa-plus text-lg"></i></button>
  </div>
</section>

@pushOnce('script')
  <script src="{{ asset('js/views/kelas/partials/pengajar-dynamic.js') }}"></script>
@endPushOnce
