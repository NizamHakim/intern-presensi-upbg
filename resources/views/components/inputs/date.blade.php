{{-- <div class="flex flex-col w-full">
    <label class="block font-medium text-sm mb-1.5 text-gray-600">{{ $label }}</label>
    <div class="relative">
        <input 
            x-init="flatpickr($el, { 
                    plugins: [
                        new monthSelectPlugin({
                            shorthand: true,
                            dateFormat: 'Y-m',
                            theme: 'light'
                        })
                    ],
                    altInput: true,
                    altFormat: 'F Y',
                    locale: 'id',
                    defaultDate: '{{ $value }}',
            })" 
            x-data="{showDatepicker: false}"
            x-click="showDatepicker = !showDatepicker" 
            {{ $attributes->merge(['class' => 'w-full px-3 py-2 rounded-md bg-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light cursor-pointer input-date']) }}
            name="{{ $inputName }}"
            placeholder="{{ $placeholder }}" 
        >
        <i class="fa-solid fa-calendar-days absolute top-1/2 transform -translate-y-1/2 right-3 text-sm text-gray-600 cursor-pointer pointer-events-none"></i>
    </div>
</div> --}}
<div class="flex flex-col w-full input-group">
    <label class="block font-medium text-sm mb-1.5 text-gray-600">{{ $label }}</label>
    <div class="relative">
        <input name="{{ $inputName }}" value="{{ $value }}" placeholder="{{ $placeholder }}" {{ $attributes->merge(['class' => 'input-date w-full px-3 py-2 rounded-md bg-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light cursor-pointer']) }}>
        <i class="fa-solid fa-calendar-days absolute top-1/2 transform -translate-y-1/2 right-3 text-sm text-gray-600 cursor-pointer pointer-events-none"></i>
    </div>
</div>

@pushOnce('script')
    <script src="{{ asset('js/views/components/inputs/date.js') }}"></script>
@endPushOnce