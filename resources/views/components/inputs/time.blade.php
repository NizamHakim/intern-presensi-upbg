<div data-default="{{ ($value) ?  $value->isoFormat("HH:mm") : null }}" class="flex flex-col w-full input-group input-time">
    <label class="block font-medium text-sm mb-1.5 text-gray-600">{{ $label }}</label>
    <div class="relative">
        <input name="{{ $inputName }}" value="{{ ($value) ? $value->isoFormat("HH:mm") : null }}" placeholder="{{ $placeholder }}" {{ $attributes->merge(['class' => 'w-full pl-3 pr-8 py-2 rounded-md bg-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light cursor-pointer']) }}>
        <i class="fa-regular fa-clock absolute top-1/2 transform -translate-y-1/2 right-3 text-sm text-gray-600 cursor-pointer pointer-events-none"></i>
    </div>
</div>

@pushOnce('script')
    <script src="{{ asset('js/views/components/inputs/time.js') }}"></script>
@endPushOnce