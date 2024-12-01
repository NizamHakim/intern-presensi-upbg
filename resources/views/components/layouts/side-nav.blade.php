{{-- desktop sidenav --}}
<nav class="sidenav hidden sticky inset-y-0 left-0 h-screen flex-col text-nowrap overflow-hidden bg-white shadow-sm lg:flex">
    <div class="w-64 h-14 flex flex-row justify-center items-center px-3 py-1 shadow-sm">
        <img src="{{ asset('images/logoGLC.png') }}" alt="LogoUPBG" class="h-full">
        {{-- <button type="button" class="sidenav-close-button flex flex-row justify-center items-center text-2xl text-upbg rounded-full size-10 transition hover:bg-gray-200"><i class="fa-solid fa-xmark"></i></i></button> --}}
    </div>
    <div class="flex-1 w-64 flex flex-col gap-3 px-3 py-4">
        <section class="flex flex-col">
            <h1 class="font-semibold text-base text-gray-800">Kelas</h1>
            <ul class="my-1 flex flex-col gap-1">
                <li class="text-sm rounded-sm-md @if(request()->routeIs('kelas.index')) bg-upbg text-white font-medium @else text-gray-600 hover:bg-gray-200 @endif"><a href="{{ route('kelas.index') }}" class="block w-full px-3 py-1">Daftar Kelas</a></li>
            </ul>
        </section>
        <section class="flex flex-col">
            <h1 class="font-semibold text-base">User</h1>
            <ul class="my-1 flex flex-col gap-1">
                <li class="text-sm rounded-sm-md @if(request()->routeIs('user.index')) bg-upbg text-white font-medium @else text-gray-600 hover:bg-gray-200 @endif"><a href="{{ route('user.index') }}" class="block w-full px-3 py-1">Daftar User</a></li>
                <li class="text-sm rounded-sm-md @if(request()->routeIs('peserta.index')) bg-upbg text-white font-medium @else text-gray-600 hover:bg-gray-200 @endif"><a href="{{ route('peserta.index') }}" class="block w-full px-3 py-1">Daftar Peserta</a></li>
            </ul>
        </section>
        <section class="flex flex-col">
            <h1 class="font-semibold text-base">Kelola Kelas</h1>
            <ul class="my-1 flex flex-col gap-1">
                <li class="text-sm rounded-sm-md @if(request()->routeIs('program-kelas.index')) bg-upbg text-white font-medium @else text-gray-600 hover:bg-gray-200 @endif"><a href="{{ route('program-kelas.index') }}" class="block w-full px-3 py-1">Program</a></li>
                <li class="text-sm rounded-sm-md @if(request()->routeIs('tipe-kelas.index')) bg-upbg text-white font-medium @else text-gray-600 hover:bg-gray-200 @endif"><a href="{{ route('tipe-kelas.index') }}" class="block w-full px-3 py-1">Tipe</a></li>
                <li class="text-sm rounded-sm-md @if(request()->routeIs('level-kelas.index')) bg-upbg text-white font-medium @else text-gray-600 hover:bg-gray-200 @endif"><a href="{{ route('level-kelas.index') }}" class="block w-full px-3 py-1">Level</a></li>
                <li class="text-sm rounded-sm-md @if(request()->routeIs('ruangan.index')) bg-upbg text-white font-medium @else text-gray-600 hover:bg-gray-200 @endif"><a href="{{ route('ruangan.index') }}" class="block w-full px-3 py-1">Ruangan</a></li>
            </ul>
        </section>
    </div>
</nav>

@pushOnce('script')
    <script src="{{ asset('js/views/components/layouts/side-nav.js') }}"></script>
@endPushOnce