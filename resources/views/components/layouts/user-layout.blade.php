<!DOCTYPE html>
<html lang="en" class="scroll-smooth scroll-pt-20">
<head>
    <x-layouts.head/>
    @stack('head')
    <title>{{ $title }}</title>
</head>
<body class="flex flex-row min-h-screen font-poppins overflow-y-scroll scrollbar" @session('toast') data-toast-type="{{ $value['type'] }}" data-toast-message="{{ $value['message'] }}" @endsession>
    @if (auth()->user()->current_role_id == 2)
        <x-layouts.side-nav/>
    @endif
    <div class="flex-1 flex flex-col">
        <x-layouts.top-bar/>
        <main class="flex-1 flex flex-row justify-center">
            <div class="w-full max-w-8xl px-6 py-4">
                {{ $slot }}
            </div>
        </main>
    </div>
    <x-layouts.script/>
    @stack('script')
</body>
</html>