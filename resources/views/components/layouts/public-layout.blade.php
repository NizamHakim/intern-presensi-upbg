<!DOCTYPE html>
<html lang="en">

<head>
  <x-layouts.head />
  <title>{{ $title }}</title>
</head>

<body class="flex min-h-screen flex-col font-poppins">
  <x-layouts.top-bar />
  <main class="flex flex-1 flex-row justify-center">
    <div class="w-full max-w-8xl">
      {{ $slot }}
    </div>
  </main>
  @stack('script')
</body>

</html>
