<div class="flex flex-row items-center">
    @foreach ($breadcrumbs as $text => $route)
        @if ($loop->last)
            <span class="font-semibold text-gray-600">{{ $text }}</span>
        @else
            <a href="{{ $route }}" class="text-upbg font-semibold underline decoration-transparent transition duration-300 hover:decoration-upbg">{{ $text }}</a>
            <i class="fa-solid fa-angle-right mx-2 text-gray-600"></i>
        @endif
    @endforeach
</div>