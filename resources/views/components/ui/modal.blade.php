<div id="{{ $id }}" class="modal fixed bg-black bg-opacity-25 z-10 inset-0 hidden opacity-0 duration-300 justify-center items-center select-none">
    <div class="modal-content bg-white scale-0 transition max-w-2xl rounded-md flex flex-col p-8 gap-6">
        {{ $slot }}
    </div>
</div>


@push('script')
    <script src="{{ asset('js/views/components/ui/modal.js') }}"></script>
@endpush