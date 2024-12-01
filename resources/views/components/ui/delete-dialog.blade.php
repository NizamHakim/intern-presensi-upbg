<div {{ $attributes->merge(['class' => 'delete-dialog fixed bg-black bg-opacity-25 z-10 inset-0 hidden opacity-0 transition duration-300 justify-center items-center select-none']) }}>
    <div class="delete-dialog-content flex flex-col p-8 gap-6 bg-white -translate-y-5 transition duration-200 mx-4 w-full max-w-2xl rounded-sm-md">
        <p class="text-xl font-semibold text-gray-700 text-center capitalize">{{ $title }}</p>
        <hr class="bg-gray-200">
        <p class="text-gray-700">{{ $message }}</p>
        @if($useSoftDelete)
            <div class="flex flex-col gap-2">
                {{ $softDeleteMessage }}
            </div>
            <div class="danger-message w-full rounded-md bg-red-100 p-3">
                <p class="text-red-600 font-semibold mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Hapus Permanen</p>
                {{ $forceDeleteMessage }}
            </div>
        @else
            <div class="danger-message w-full rounded-md bg-red-100 p-3">
                <p class="text-red-600 font-semibold mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Peringatan</p>
                {{ $deleteMessage }}
            </div>
        @endif
        <form action="{{ $action }}" method="POST" class="flex flex-col items-center">
            @csrf
            @method('DELETE')
            @if ($useSoftDelete)
                <x-inputs.checkbox inputName="force-delete" value="force" :checked="false" label="Hapus permanen" class="checked:bg-red-600 checked:border-red-600"/>
            @endif
            {{ $hiddenInputs }}
            <hr class="bg-gray-200 w-full my-4">
            <div class="flex flex-row w-full justify-end gap-4">
                <button type="button" class="cancel-button button-style border-none text-gray-600 bg-white hover:bg-gray-100">Cancel</button>
                <button type="submit" class="submit-button button-style bg-red-600 text-white hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>

@pushOnce('script')
    <script src="{{ asset('js/views/components/ui/delete-dialog.js') }}"></script>
@endpushOnce