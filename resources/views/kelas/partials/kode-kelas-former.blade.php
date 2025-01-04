<div class="input-group col-span-full flex flex-col">
  <h1 class="input-label">Kode Kelas</h1>
  <input name="kode-kelas" value="{{ $kelas ? $kelas->kode : null }}" readonly type="text" placeholder="Isi kolom dibawah untuk membuat kode kelas" class="input-appearance truncate font-medium outline-none hover:bg-gray-200">
</div>

<hr class="my-5">

<section id="kode-kelas-section" class="grid grid-cols-6 gap-x-3 gap-y-4">
  <div class="input-group kode-former col-span-full md:col-span-3 xl:col-span-2">
    <p class="input-label">Program Kelas</p>
    <x-inputs.dropdown.select name="program" placeholder="Pilih program" :selected="$kelas ? ['text' => $kelas->program->nama . ' (' . $kelas->program->kode . ')', 'value' => $kelas->program->id] : null" class="program-dropdown">
      @foreach ($programOptions as $program)
        <x-inputs.dropdown.option :value="$program->id" class="{{ $kelas && $program->id == $kelas->program->id ? 'selected' : '' }}">{{ "$program->nama ($program->kode)" }}</x-inputs.dropdown.option>
      @endforeach
    </x-inputs.dropdown.select>
  </div>

  <div class="input-group kode-former col-span-full md:col-span-3 xl:col-span-2">
    <p class="input-label">Tipe Kelas</p>
    <x-inputs.dropdown.select name="tipe" placeholder="Pilih tipe" :selected="$kelas ? ['text' => $kelas->tipe->nama . ' (' . $kelas->tipe->kode . ')', 'value' => $kelas->tipe->id] : null" class="tipe-dropdown">
      @foreach ($tipeOptions as $tipe)
        <x-inputs.dropdown.option :value="$tipe->id" class="{{ $kelas && $tipe->id == $kelas->tipe->id ? 'selected' : '' }}">{{ "$tipe->nama ($tipe->kode)" }}</x-inputs.dropdown.option>
      @endforeach
    </x-inputs.dropdown.select>
  </div>

  <div class="input-group kode-former col-span-full md:col-span-3 xl:col-span-2">
    <p class="input-label">Nomor Kelas</p>
    <input type="number" name="nomor-kelas" value="{{ $kelas ? $kelas->nomor_kelas : null }}" class="input-appearance input-outline" placeholder="Nomor kelas">
  </div>

  <div class="input-group kode-former col-span-full md:col-span-3 xl:col-span-2">
    <p class="input-label">Level Kelas</p>
    <x-inputs.dropdown.select name="level" placeholder="Pilih level" :selected="$kelas ? ['text' => $kelas->level->nama . ' (' . $kelas->level->kode . ')', 'value' => $kelas->level->id] : null" class="level-dropdown">
      @foreach ($levelOptions as $level)
        <x-inputs.dropdown.option :value="$level->id" class="{{ $kelas && $level->id == $kelas->level->id ? 'selected' : '' }}">{{ "$level->nama ($level->kode)" }}</x-inputs.dropdown.option>
      @endforeach
    </x-inputs.dropdown.select>
  </div>

  <div class="input-group kode-former col-span-full md:col-span-3 xl:col-span-2">
    <p class="input-label">Banyak Pertemuan</p>
    <input type="number" name="banyak-pertemuan" value="{{ $kelas ? $kelas->banyak_pertemuan : null }}" class="input-appearance input-outline" placeholder="Banyak pertemuan">
  </div>

  <div class="input-group kode-former col-span-full md:col-span-3 xl:col-span-2">
    <p class="input-label">Tanggal Mulai</p>
    <x-inputs.date inputName="tanggal-mulai" :value="$kelas ? $kelas->tanggal_mulai : null" placeholder="Pilih tanggal mulai" />
  </div>
</section>

@pushOnce('script')
  <script src="{{ asset('js/views/kelas/partials/kode-kelas-former.js') }}"></script>
@endPushOnce
