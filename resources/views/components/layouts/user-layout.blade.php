<!DOCTYPE html>
<html lang="en" class="scroll-smooth scroll-pt-20">
<head>
    <x-layouts.head/>
    @stack('head')
    <title>{{ $title }}</title>
</head>
<body class="flex flex-row min-h-screen font-poppins overflow-y-scroll scrollbar" @session('toast') data-toast-type="{{ $value['type'] }}" data-toast-message="{{ $value['message'] }}" @endsession>
    <x-layouts.side-nav/>
    <div class="flex-1 flex flex-col">
        <x-layouts.top-bar/>
        <main class="flex-1 flex flex-row justify-center bg-gray-100 text-sm text-gray-600">
            <div class="w-full max-w-6xl 2xl:max-w-7xl px-4 pt-4 pb-40">
                {{ $slot }}
            </div>
        </main>
    </div>
    <x-layouts.script/>
    @stack('script')
</body>
</html>