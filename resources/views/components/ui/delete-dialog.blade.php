<div id="delete-dialog" class="fixed bg-black bg-opacity-25 z-10 inset-0 hidden opacity-0 duration-300 justify-center items-center">
    <div id="delete-dialog-content" class="bg-white scale-0 transition max-w-2xl rounded-md flex flex-col p-8 gap-6">
        <p class="text-2xl font-bold text-gray-800 text-center">{{ $title }}</p>
        <p class="text-center text-gray-800">{{ $message }}</p>
        @if($useSoftDelete)
            <div class="flex flex-col gap-2">
                {{ $softDeleteMessage }}
            </div>
            <div class="danger-message w-full rounded-md bg-red-100 p-3">
                <p class="text-red-600 font-semibold mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Hapus Permanen</p>
                {{ $forceDeleteMessage }}
            </div>
        @endif
        <form action="{{ $action }}" method="POST" class="flex flex-col items-center">
            @csrf
            @method('DELETE')
            @if ($useSoftDelete)
                <x-inputs.checkbox inputName="force-delete" value="force" :checked="false" label="Hapus permanen" class="checked:bg-red-600 checked:border-red-600"/>
            @endif
            <input type="hidden" name="{{ $inputName }}">
            <div class="flex flex-row justify-center gap-4 mt-6">
                <button type="button" class="cancel-button px-8 py-2 text-gray-800 border border-gray-300 bg-white hover:bg-gray-100 font-semibold rounded-sm-md">Cancel</button>
                <button type="submit" class="px-8 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-sm-md">Delete</button>
            </div>
        </form>
    </div>
</div>

@push('script')
    <script src="{{ asset('js/views/components/ui/delete-dialog.js') }}"></script>
@endpush