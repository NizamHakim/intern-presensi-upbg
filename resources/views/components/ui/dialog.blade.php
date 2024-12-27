<div {{ $attributes->merge(['class' => 'dialog absolute z-10 hidden min-w-24 divide-y rounded-sm-md border bg-white text-sm font-medium opacity-0 transition duration-75 shadow-md ']) }}>
  {{ $slot }}
</div>

@pushOnce('script')
  <script src="{{ asset('js/views/components/ui/dialog.js') }}"></script>
@endPushOnce
