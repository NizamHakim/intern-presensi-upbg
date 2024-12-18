<div id="{{ $id }}" class="modal hidden fixed bg-black bg-opacity-25 z-10 inset-0 opacity-0 transition duration-300 justify-center items-center select-none">
    <div class="modal-content flex flex-col p-8 bg-white -translate-y-5 transition duration-200 mx-4 w-full max-w-2xl rounded-sm-md">
        {{ $slot }}
    </div>
</div>

@pushOnce('script')
    <script src="{{ asset('js/views/components/ui/modal.js') }}"></script>
@endPushOnce