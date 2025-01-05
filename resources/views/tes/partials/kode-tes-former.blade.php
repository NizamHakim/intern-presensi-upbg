<div class="input-group col-span-full flex flex-col">
  <h1 class="mb-1.5 font-medium text-gray-700">Kode Kelas</h1>
  <input name="kode-tes" value="{{ $tes ? $tes->kode : null }}" readonly type="text" placeholder="Isi kolom dibawah untuk membuat kode tes" class="input-appearance truncate font-medium outline-none hover:bg-gray-200">
</div>

<hr class="my-5">

<section id="kode-tes-section" class="grid grid-cols-1 gap-x-3 gap-y-4">
  <div class="input-group kode-former col-span-full">
    <p class="input-label">Tipe Tes</p>
    <x-inputs.dropdown.select name="tipe" placeholder="Pilih tipe" :selected="$tes ? ['text' => $tes->tipe->nama . ' (' . $tes->tipe->kode . ')', 'value' => $tes->tipe->id] : null" class="tipe-dropdown">
      @foreach ($tipeOptions as $tipe)
        <x-inputs.dropdown.option :value="$tipe->id" class="{{ $tes && $tipe->id == $tes->tipe->id ? 'selected' : '' }}">{{ "$tipe->nama ($tipe->kode)" }}</x-inputs.dropdown.option>
      @endforeach
    </x-inputs.dropdown.select>
  </div>

  <div class="input-group kode-former col-span-full">
    <p class="input-label">Nomor Tes</p>
    <input type="number" name="nomor-tes" value="{{ $tes ? $tes->nomor : null }}" class="input-appearance input-outline" placeholder="Nomor tes">
  </div>

  <div class="input-group kode-former col-span-full">
    <p class="input-label">Tanggal Tes</p>
    <x-inputs.date inputName="tanggal" :value="$tes ? $tes->tanggal : null" placeholder="Pilih tanggal tes" />
  </div>
</section>

@pushOnce('script')
  <script src="{{ asset('js/views/tes/partials/kode-tes-former.js') }}"></script>
@endPushOnce
