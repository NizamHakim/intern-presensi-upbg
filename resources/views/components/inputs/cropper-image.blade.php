<div id="cropper-modal" class="fixed bg-black bg-opacity-25 z-10 inset-0 opacity-0 duration-300 hidden justify-center items-center select-none">
    <div id="cropper-modal-content" class="bg-white scale-0 transition rounded-md flex flex-col p-6 gap-4">
        <h1 class="font-bold text-gray-800">Edit Foto</h1>
        <div class="bg-black  w-[600px] h-[500px] flex flex-row justify-center rounded-md">
            <img src="" class="cropper-preview w-full h-full block object-contain">
        </div>
        <div class="flex flex-row justify-end items-center gap-4">
            <button type="button" class="cancel-button px-4 py-2 rounded-md font-medium text-gray-800 bg-white transition hover:bg-gray-100">Cancel</button>
            <button type="button" class="crop-button px-4 py-2 rounded-md font-medium text-white bg-upbg transition hover:bg-upbg-dark">Crop</button>
        </div>
    </div>
</div>

@push('script')
    <script src="{{ asset('js/views/components/inputs/cropper.js') }}"></script>
@endpush