<div data-default="{{ $value }}" {{ $attributes->merge(['class' => 'flex flex-col w-full input-date ']) }}>
    <div class="relative">
        <input type="date" name="{{ $inputName }}" value="{{ $value }}" placeholder="{{ $placeholder }}" class="w-full truncate pl-3 pr-8 py-2 h-10 rounded-md bg-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light cursor-pointer">
        <i class="fa-solid fa-calendar-days absolute top-1/2 transform -translate-y-1/2 right-3 text-sm text-gray-600 cursor-pointer pointer-events-none"></i>
    </div>
</div>

@pushOnce('script')
    <script src="{{ asset('js/views/components/inputs/date.js') }}"></script>
@endPushOnce