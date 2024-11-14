<div id="toast" class="fixed hidden transition translate-y-2 duration-300 opacity-0 flex-row gap-4 items-center px-4 py-4 right-5 bottom-10 rounded-md bg-white shadow-strong w-96 z-10 after:absolute after:rounded-bl-md @if($status == 'success') after:bg-green-600 @elseif ($status == 'error') after:bg-red-600 @endif after:h-1 after:bottom-0 after:left-0 after:animate-[toast-progress_3s_linear]">
    @if ($status == 'success')
        <i class="fa-solid fa-circle-check text-green-600 text-3xl mx-1"></i>
    @elseif ($status == 'error')
        <i class="fa-solid fa-circle-xmark text-red-600 text-3xl mx-1"></i>
    @endif
    <div class="flex flex-col flex-1">
        <h1 class="text-base font-semibold">Success</h1>
        <p class="text-sm text-gray-600">
            {{ $slot }}
        </p>
    </div>
    <button type="button" class="close-toast-button bg-white size-6 rounded-full transition hover:bg-gray-100">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>


@push('script')
    <script src="{{ asset('js/views/components/ui/toast.js') }}"></script>
@endpush