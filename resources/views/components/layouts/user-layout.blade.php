<!DOCTYPE html>
<html lang="en" class="scroll-pt-20 scroll-smooth">

<head>
  <x-layouts.head />
  <title>{{ $title }}</title>
</head>

<body class="scrollbar flex min-h-screen min-w-0 flex-row overflow-y-scroll font-poppins">
  <x-layouts.side-nav>
    @isset($sidenav)
      {{ $sidenav }}
    @endisset
  </x-layouts.side-nav>
  <div class="flex min-w-0 flex-1 flex-col">
    <x-layouts.top-bar />
    <main class="flex min-w-0 flex-1 flex-row justify-center bg-gray-100 text-sm text-gray-600">
      <div class="w-full min-w-0 max-w-6xl px-4 pb-40 pt-4 2xl:max-w-7xl">
        {{ $slot }}
        @stack('components-supports')
      </div>
    </main>
  </div>
  <x-layouts.script />
  <script src="{{ asset('js/views/components/layouts/user-layout.js') }}"></script>
  @stack('script')
</body>

</html>
