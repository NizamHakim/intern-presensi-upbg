<section id="jadwal-section" class="flex flex-col gap-2">
  <h1 class="input-label">Jadwal</h1>
  @if ($kelas)
    <p class="rounded-sm-md bg-blue-100 p-4 font-medium text-upbg">Jadwal pertemuan yang sudah dibuat tidak akan otomatis diubah</p>
  @endif

  <div class="jadwal-container flex flex-col gap-3">
    @if ($kelas)
      @foreach ($kelas->jadwal as $jadwal)
        <div class="jadwal-item @if ($loop->first) md:mr-11 @endif flex min-w-0 items-center rounded-sm-md border py-1 shadow-sm md:border-none md:p-0 md:shadow-none">
          <div class="mobile-view ml-3 flex w-full min-w-0 items-center gap-2 md:hidden">
            <p class="truncate"><i class="fa-solid fa-calendar-days mr-2"></i><span class="hari">{{ $jadwal->namaHari }}</span>,</p>
            <p class="waktu-mulai truncate">{{ $jadwal->waktu_mulai->isoFormat('HH:mm') }}</p>
            <span class="text-lg">-</span>
            <p class="waktu-selesai truncate">{{ $jadwal->waktu_selesai->isoFormat('HH:mm') }}</p>
            <div class="relative ml-auto">
              <button type="button" class="menu px-3"><i class="fa-solid fa-ellipsis-vertical"></i></button>
              <x-ui.dialog class="right-0 top-full">
                <button type="button" class="edit-jadwal w-full px-2 py-1.5 text-left">Edit</button>
                @if (!$loop->first)
                  <button type="button" class="delete-jadwal w-full px-2 py-1.5 text-left text-red-600">Delete</button>
                @endif
              </x-ui.dialog>
            </div>
          </div>
          <div class="desktop-view hidden w-full grid-cols-[1fr_1fr_fit-content(100px)_1fr_fit-content(100px)] md:grid">
            <div class="input-group mr-2">
              <x-inputs.dropdown.select name="hari" placeholder="Pilih hari" class="hari-dropdown" :selected="['text' => $jadwal->namaHari, 'value' => $jadwal->hari]">
                @foreach ($hariOptions as $hari)
                  <x-inputs.dropdown.option :value="$hari['value']" class="{{ $hari['value'] == $jadwal->hari ? 'selected' : '' }}">{{ $hari['text'] }}</x-inputs.dropdown.option>
                @endforeach
              </x-inputs.dropdown.select>
            </div>
            <div class="input-group">
              <x-inputs.time inputName="waktu-mulai" placeholder="Waktu mulai" class="waktu-mulai-fp" :value="$jadwal->waktu_mulai"></x-inputs.time>
            </div>
            <span class="mx-2 mt-1 text-lg">-</span>
            <div class="input-group">
              <x-inputs.time inputName="waktu-selesai" placeholder="Waktu selesai" class="waktu-selesai-fp" :value="$jadwal->waktu_selesai"></x-inputs.time>
            </div>
            @if (!$loop->first)
              <button type="button" class="delete-jadwal btn-rounded btn-white ml-2 hidden text-red-600 md:flow-root"><i class="fa-regular fa-trash-can"></i></button>
            @endif
          </div>
        </div>
      @endforeach
    @else
      <div class="jadwal-item double-view flex min-w-0 items-center md:mr-11">
        <div class="mobile-view w-full md:hidden">
          <div class="flex w-full min-w-0 items-center gap-2 rounded-sm-md border py-1 pl-3 shadow-sm">
            <p class="truncate"><i class="fa-solid fa-calendar-days mr-2"></i><span class="hari">Hari</span>,</p>
            <p class="waktu-mulai truncate">Mulai</p>
            <span class="text-lg">-</span>
            <p class="waktu-selesai truncate">Selesai</p>
            <div class="relative ml-auto">
              <button type="button" class="menu px-3"><i class="fa-solid fa-ellipsis-vertical"></i></button>
              <x-ui.dialog class="right-0 top-full">
                <button type="button" class="edit-jadwal w-full px-2 py-1.5 text-left">Edit</button>
              </x-ui.dialog>
            </div>
          </div>
        </div>
        <div class="desktop-view hidden w-full grid-cols-[1fr_1fr_fit-content(100px)_1fr_fit-content(100px)] md:grid">
          <div class="input-group mr-2">
            <x-inputs.dropdown.select name="hari" placeholder="Pilih hari" class="hari-dropdown">
              @foreach ($hariOptions as $hari)
                <x-inputs.dropdown.option :value="$hari['value']">{{ $hari['text'] }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          <div class="input-group">
            <x-inputs.time inputName="waktu-mulai" placeholder="Waktu mulai" class="waktu-mulai-fp"></x-inputs.time>
          </div>
          <span class="mx-2 mt-1 text-lg">-</span>
          <div class="input-group">
            <x-inputs.time inputName="waktu-selesai" placeholder="Waktu selesai" class="waktu-selesai-fp"></x-inputs.time>
          </div>
        </div>
      </div>
    @endif
    <template id="template-jadwal">
      <div class="jadwal-item double-view flex min-w-0 items-center">
        <div class="mobile-view w-full md:hidden">
          <div class="flex w-full min-w-0 items-center gap-2 rounded-sm-md border py-1 pl-3 shadow-sm">
            <p class="truncate"><i class="fa-solid fa-calendar-days mr-2"></i><span class="hari">Hari</span>,</p>
            <p class="waktu-mulai truncate">Mulai</p>
            <span class="text-lg">-</span>
            <p class="waktu-selesai truncate">Selesai</p>
            <div class="relative ml-auto">
              <button type="button" class="menu px-3"><i class="fa-solid fa-ellipsis-vertical"></i></button>
              <x-ui.dialog class="right-0 top-full">
                <button type="button" class="edit-jadwal w-full px-2 py-1.5 text-left">Edit</button>
                <button type="button" class="delete-jadwal w-full px-2 py-1.5 text-left text-red-600">Delete</button>
              </x-ui.dialog>
            </div>
          </div>
        </div>
        <div class="desktop-view hidden w-full grid-cols-[1fr_1fr_fit-content(100px)_1fr_fit-content(100px)] md:grid">
          <div class="input-group mr-2">
            <x-inputs.dropdown.select name="hari" placeholder="Pilih hari" class="hari-dropdown">
              @foreach ($hariOptions as $hari)
                <x-inputs.dropdown.option :value="$hari['value']">{{ $hari['text'] }}</x-inputs.dropdown.option>
              @endforeach
            </x-inputs.dropdown.select>
          </div>
          <div class="input-group">
            <x-inputs.time inputName="waktu-mulai" placeholder="Waktu mulai" class="waktu-mulai-fp"></x-inputs.time>
          </div>
          <span class="mx-2 mt-1 text-lg">-</span>
          <div class="input-group">
            <x-inputs.time inputName="waktu-selesai" placeholder="Waktu selesai" class="waktu-selesai-fp"></x-inputs.time>
          </div>
          <button type="button" class="delete-jadwal btn-rounded btn-white ml-2 hidden text-red-600 md:flow-root"><i class="fa-regular fa-trash-can"></i></button>
        </div>
      </div>
    </template>
  </div>
  <div class="mt-1 flex w-full flex-row items-center justify-center gap-4">
    <button type="button" class="tambah-jadwal btn-rounded btn-white hover:bg-gray-200"><i class="fa-solid fa-plus text-lg"></i></button>
  </div>
</section>

@pushOnce('components-supports')
  <x-ui.modal id="add-edit-jadwal-modal">
    <form class="flex flex-col gap-4">
      <div class="input-group">
        <p class="input-label">Hari</p>
        <x-inputs.dropdown.select name="hari" placeholder="Pilih hari" class="hari-dropdown">
          @foreach ($hariOptions as $hari)
            <x-inputs.dropdown.option :value="$hari['value']">{{ $hari['text'] }}</x-inputs.dropdown.option>
          @endforeach
        </x-inputs.dropdown.select>
      </div>
      <div class="input-group">
        <p class="input-label">Waktu Mulai</p>
        <x-inputs.time inputName="waktu-mulai" placeholder="Waktu mulai" class="waktu-mulai-fp"></x-inputs.time>
      </div>
      <div class="input-group">
        <p class="input-label">Waktu Selesai</p>
        <x-inputs.time inputName="waktu-selesai" placeholder="Waktu selesai" class="waktu-selesai-fp"></x-inputs.time>
      </div>
      <div class="flex justify-end gap-4">
        <button type="button" class="cancel-button btn btn-white border-none shadow-none">Cancel</button>
        <button type="submit" class="submit-button btn">Tambah</button>
      </div>
    </form>
  </x-ui.modal>
@endPushOnce

@pushOnce('script')
  <script src="{{ asset('js/views/kelas/partials/jadwal-dynamic.js') }}"></script>
@endPushOnce
