<section class="flex flex-col">
    <h1 class="font-semibold text-base text-gray-800 truncate">{{ $title }}</h1>
    <ul class="my-2 flex flex-col gap-1">
        {{ $slot }}
    </ul>
</section>