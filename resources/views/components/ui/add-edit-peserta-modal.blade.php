<x-ui.modal id="add-edit-peserta-modal">
    <form class="flex flex-col gap-4">
        <div class="input-group flex flex-col gap-1">
            <label class="font-medium text-gray-700">NIK / NRP :</label>
            <input type="text" name="nik-peserta" placeholder="NIK / NRP" class="input-style autofill:bg-white" required>
        </div>
        <div class="input-group flex flex-col gap-1">
            <label class="font-medium text-gray-700">Nama :</label>
            <input type="text" name="nama-peserta" placeholder="Nama" class="input-style" required>
        </div>
        <div class="input-group flex flex-col gap-1">
            <label class="font-medium text-gray-700">Departemen / Occupation :</label>
            <input type="text" name="occupation-peserta" placeholder="Departemen / Occupation" class="input-style" required>
        </div>
        <div class="flex flex-row justify-end gap-4">
            <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
            <button type="submit" class="submit-button button-style">Tambah</button>
        </div>
    </form>
</x-ui.modal>