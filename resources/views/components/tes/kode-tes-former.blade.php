<div class="flex flex-col col-span-full input-group">
    <h1 class="text-gray-700 font-medium mb-1.5">Kode Kelas</h1>
    <input name="kode-tes" value="{{ ($tes) ? $tes->kode : null }}" readonly type="text" placeholder="Isi kolom dibawah untuk membuat kode tes" class="input-style truncate">
</div>

<hr class="my-5">

<section id="kode-tes-section" class="grid grid-cols-1 gap-x-3 gap-y-4">
    <div class="input-group col-span-full kode-former">
        <p class="input-label">Tipe Tes</p>
        <x-inputs.dropdown.select name="tipe" placeholder="Pilih tipe" :selected="($tes) ? ['text' => $tes->tipe->nama . ' (' . $tes->tipe->kode . ')', 'value' => $tes->tipe->id] : null" class="tipe-dropdown">
            @foreach ($tipeOptions as $tipe)
                <x-inputs.dropdown.option :value="$tipe->id" class="{{ ($tes && $tipe->id == $tes->tipe->id) ? 'selected' : '' }}">{{ "$tipe->nama ($tipe->kode)" }}</x-inputs.dropdown.option>
            @endforeach
        </x-inputs.dropdown.select>
    </div>

    <div class="input-group col-span-full kode-former">
        <p class="input-label">Nomor Tes</p>
        <input type="number" name="nomor-tes" value="{{ ($tes) ? $tes->nomor : null }}" class="input-style input-number" placeholder="Nomor tes">
    </div>

    <div class="input-group col-span-full kode-former">
        <p class="input-label">Tanggal Tes</p>
        <x-inputs.date inputName="tanggal" value="{{ ($tes) ? $tes->tanggal : null }}" placeholder="Pilih tanggal tes"/>
    </div>
</section>

@pushOnce('script')
    <script src="{{ asset('js/views/components/tes/kode-tes-former.js') }}"></script>    
@endPushOnce