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
            <x-inputs.time inputName="waktu-mulai" placeholder="Waktu mulai" class="waktu-mulai"></x-inputs.time>
        </div>
        <div class="input-group">
            <p class="input-label">Waktu Selesai</p>
            <x-inputs.time inputName="waktu-selesai" placeholder="Waktu selesai" class="waktu-selesai"></x-inputs.time>
        </div>
        <div class="flex flex-row justify-end gap-4">
            <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
            <button type="submit" class="submit-button button-style">Tambah</button>
        </div>
    </form>
</x-ui.modal>

{{-- only for edit-kelas.blade.php and tambah-kelas.blade.php, script is on jadwal-dynamic.blade.php --}}