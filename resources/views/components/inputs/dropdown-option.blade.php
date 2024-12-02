<li data-value="{{ $value }}" 
    class="dropdown-option px-2 py-2 cursor-pointer hover:bg-gray-200 border-l-4 truncate last:rounded-b-md 
    @if($selected) border-upbg @else border-transparent @endif">
    {{ $slot }}
</li>