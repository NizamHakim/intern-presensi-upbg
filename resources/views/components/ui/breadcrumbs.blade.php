<div class="flex flex-row items-center flex-wrap text-xs md:text-sm">
    @foreach ($breadcrumbs as $text => $route)
        @if ($loop->last)
            <span class="font-medium text-gray-600 whitespace-nowrap">{{ $text }}</span>
        @else
            <a href="{{ $route }}" class="text-upbg font-medium underline decoration-transparent transition duration-300 hover:decoration-upbg whitespace-nowrap">{{ $text }}</a>
            <i class="fa-solid fa-angle-right mx-2 text-gray-600"></i>
        @endif
    @endforeach
</div>