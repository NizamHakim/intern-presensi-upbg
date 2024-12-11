<li class="text-sm rounded-sm-md @if(request()->routeIs($routeName) ) bg-upbg text-white font-medium @else text-gray-600 hover:bg-gray-200 @endif">
    <a href="{{ $href }}" class="block w-full px-3 py-1">{{ $slot }}</a>
</li>