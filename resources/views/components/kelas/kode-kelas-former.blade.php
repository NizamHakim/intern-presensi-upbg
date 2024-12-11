<div class="flex flex-col col-span-full input-group">
    <h1 class="text-gray-700 font-medium mb-1.5">Kode Kelas</h1>
    <input name="kode-kelas" value="{{ $kelas->kode }}" readonly type="text" placeholder="Isi kolom dibawah untuk membuat kode kelas" class="input-style truncate">
</div>

<hr class="my-5">

<section id="kode-kelas-section" class="grid grid-cols-6 gap-x-3 gap-y-4">
    <div class="input-group col-span-full kode-former md:col-span-3 xl:col-span-2">
        <p class="input-label">Program Kelas</p>
        <x-inputs.dropdown.select name="program" placeholder="Pilih program" :selected="['text' => $kelas->program->nama . ' (' . $kelas->program->kode . ')', 'value' => $kelas->program->id]" class="program-dropdown">
            @foreach ($programOptions as $program)
                <x-inputs.dropdown.option :value="$program->id" class="{{ ($program->id == $kelas->program->id) ? 'selected' : '' }}">{{ "$program->nama ($program->kode)" }}</x-inputs.dropdown.option>
            @endforeach
        </x-inputs.dropdown.select>
    </div>
    
    <div class="input-group col-span-full kode-former md:col-span-3 xl:col-span-2">
        <p class="input-label">Tipe Kelas</p>
        <x-inputs.dropdown.select name="tipe" placeholder="Pilih tipe" :selected="['text' => $kelas->tipe->nama . ' (' . $kelas->tipe->kode . ')', 'value' => $kelas->tipe->id]" class="tipe-dropdown">
            @foreach ($tipeOptions as $tipe)
                <x-inputs.dropdown.option :value="$tipe->id" class="{{ ($tipe->id == $kelas->tipe->id) ? 'selected' : '' }}">{{ "$tipe->nama ($tipe->kode)" }}</x-inputs.dropdown.option>
            @endforeach
        </x-inputs.dropdown.select>
    </div>

    <div class="input-group col-span-full kode-former md:col-span-3 xl:col-span-2">
        <p class="input-label">Nomor Kelas</p>
        <input type="number" name="nomor-kelas" value="{{ $kelas->nomor_kelas }}" class="input-style input-number" placeholder="Nomor kelas">
    </div>

    <div class="input-group col-span-full kode-former md:col-span-3 xl:col-span-2">
        <p class="input-label">Level Kelas</p>
        <x-inputs.dropdown.select name="level" placeholder="Pilih level" :selected="['text' => $kelas->level->nama . ' (' . $kelas->level->kode . ')', 'value' => $kelas->level->id]" class="level-dropdown">
            @foreach ($levelOptions as $level)
                <x-inputs.dropdown.option :value="$level->id" class="{{ ($level->id == $kelas->level->id) ? 'selected' : '' }}">{{ "$level->nama ($level->kode)" }}</x-inputs.dropdown.option>
            @endforeach
        </x-inputs.dropdown.select>
    </div>

    <div class="input-group col-span-full kode-former md:col-span-3 xl:col-span-2">
        <p class="input-label">Banyak Pertemuan</p>
        <input type="number" name="banyak-pertemuan" value="{{ $kelas->banyak_pertemuan }}" class="input-style input-number" placeholder="Banyak pertemuan">
    </div>

    <div class="input-group col-span-full kode-former md:col-span-3 xl:col-span-2">
        <p class="input-label">Tanggal Mulai</p>
        <x-inputs.date inputName="tanggal-mulai" value="{{ $kelas->tanggal_mulai }}" placeholder="Pilih tanggal mulai"/>
    </div>
</section>

@pushOnce('script')
    <script src="{{ asset('js/views/components/kelas/kode-kelas-former.js') }}"></script>    
@endPushOnce