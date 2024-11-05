<!DOCTYPE html>
<html lang="en">
<head>
    <x-layouts.head/>
    <title>{{ $title }}</title>
</head>
<body x-data="{ showSideNav: true }" class="flex flex-row min-h-screen font-poppins">
    <x-layouts.side-nav/>
    <div class="flex-1 flex flex-col">
        <x-layouts.top-bar/>
        <main class="flex-1 flex flex-row justify-center">
            <div class="w-full max-w-8xl px-3 py-4">
                {{ $slot }}
            </div>
        </main>
    </div>
    <x-layouts.script/>
    @stack('script')
</body>
</html>