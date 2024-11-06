<!DOCTYPE html>
<html lang="en">
<head>
    <x-layouts.head/>
    <title>{{ $title }}</title>
</head>
<body class="flex flex-col min-h-screen font-poppins">
    <x-layouts.top-bar/>
    <main class="flex-1 flex flex-row justify-center">
        <div class="w-full max-w-8xl">
            {{ $slot }}
        </div>
    </main>
</body>
</html>