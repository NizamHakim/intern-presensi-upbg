<section id="ruangan-section" class="flex flex-col gap-2">
  <h1 class="input-label">Ruangan</h1>
  @if ($tes)
    <div class="info-container">
      <p class="mb-1 font-semibold"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
      <ul class="list-outside list-disc space-y-1 pl-5">
        <li>Peserta pada ruangan yang dihapus akan dialokasikan ke ruangan yang masih kosong</li>
        <li>Jika kapasitas total tidak cukup maka sisa peserta akan dimasukkan ke ruangan terakhir</li>
      </ul>
    </div>
  @endif
  <div class="ruangan-container flex flex-col gap-3">
    @if ($tes)
      @foreach ($tes->ruangan as $ruangan)
        <div class="ruangan-item @if ($loop->first) mr-11 @endif grid grid-flow-col grid-cols-1">
          <div class="input-group">
            <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" :selected="['text' => $ruangan->kode . ' (' . $ruangan->kapasitas . ')', 'value' => $ruangan->id]" class="ruangan-dropdown">
              @foreach ($ruanganOptions as $option)
                <x-inputs.dropdown.option :value="$option->id" class="{{ $option->id == $ruangan->id ? 'selected' : '' }}">{{ "$option->kode ($option->kapasitas)" }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          @if (!$loop->first)
            <button type="button" class="delete-ruangan btn-rounded btn-white ml-2 text-red-600"><i class="fa-regular fa-trash-can"></i></button>
          @endif
        </div>
      @endforeach
    @else
      <div class="ruangan-item mr-11 grid grid-flow-col grid-cols-1">
        <div class="input-group">
          <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" class="ruangan-dropdown">
            @foreach ($ruanganOptions as $option)
              <x-inputs.dropdown.option :value="$option->id">{{ "$option->kode ($option->kapasitas)" }}</x-inputs.dropdown.option>
            @endforeach
          </x-inputs.dropdown.select>
        </div>
      </div>
    @endif
    <template id="template-ruangan">
      <div class="ruangan-item grid grid-flow-col grid-cols-1">
        <div class="input-group">
          <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" class="ruangan-dropdown">
            @foreach ($ruanganOptions as $option)
              <x-inputs.dropdown.option :value="$option->id">{{ "$option->kode ($option->kapasitas)" }}</x-inputs.dropdown.option>
            @endforeach
          </x-inputs.dropdown.select>
        </div>
        <button type="button" class="delete-ruangan btn-rounded btn-white ml-2 text-red-600"><i class="fa-regular fa-trash-can"></i></button>
      </div>
    </template>
  </div>
  <div class="mt-1 flex w-full flex-row items-center justify-center gap-4">
    <button type="button" class="tambah-ruangan btn-rounded btn-white hover:bg-gray-200"><i class="fa-solid fa-plus text-lg"></i></button>
  </div>
</section>

@pushOnce('script')
  <script src="{{ asset('js/views/tes/partials/ruangan-dynamic.js') }}"></script>
@endPushOnce
