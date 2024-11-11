{{-- mobile sidenav --}}
{{-- <nav x-show="showSideNav" x-on:click="showSideNav = false" class="block lg:hidden fixed inset-0 bg-black bg-opacity-60 z-50">
    <div x-show="showSideNav" 
        x-transition:enter="transition ease-out" 
        x-transition:enter-start="-left-96" 
        x-transition:enter-end="left-0" 
        x-transition:leave="transition ease-in" 
        x-transition:leave-start="left-0" 
        x-transition:leave-end="-left-96" 
        class="fixed inset-y-0 w-64 h-screen bg-gray-100 flex flex-col transition-all">
        <div class="h-14 border-b flex flex-row justify-between items-center px-3 py-1">
            <img src="{{ asset('images/logoGLC.png') }}" alt="LogoUPBG" class="h-full">
            <button x-on:click="showSideNav = false" type="button" class="flex flex-row justify-center items-center text-2xl text-upbg rounded-full size-10 transition hover:bg-gray-200"><i class="fa-solid fa-xmark"></i></i></button>
        </div>
        <div class="flex-1 w-full flex flex-col gap-3 px-3 py-4">
            <section class="flex flex-col">
                <h1 class="font-semibold text-base">Kelas</h1>
                <ul class="my-1 flex flex-col gap-1">
                    <li x-on:click="showSideNav = false" class="text-sm rounded-sm-md bg-upbg text-white font-medium"><a href="#" class="block w-full px-3 py-1">Daftar Kelas</a></li>
                </ul>
            </section>
            <section class="flex flex-col">
                <h1 class="font-semibold text-base">User</h1>
                <ul class="my-1 flex flex-col gap-1">
                    <li x-on:click="showSideNav = false" class="text-sm rounded-sm-md hover:bg-gray-200"><a href="#" class="block w-full px-3 py-1">Daftar User</a></li>
                    <li x-on:click="showSideNav = false" class="text-sm rounded-sm-md hover:bg-gray-200"><a href="#" class="block w-full px-3 py-1">Cari Peserta</a></li>
                </ul>
            </section>
            <section class="flex flex-col">
                <h1 class="font-semibold text-base">Kelola Kelas</h1>
                <ul class="my-1 flex flex-col gap-1">
                    <li x-on:click="showSideNav = false" class="text-sm rounded-sm-md hover:bg-gray-200"><a href="#" class="block w-full px-3 py-1">Program</a></li>
                    <li x-on:click="showSideNav = false" class="text-sm rounded-sm-md hover:bg-gray-200"><a href="#" class="block w-full px-3 py-1">Tipe</a></li>
                    <li x-on:click="showSideNav = false" class="text-sm rounded-sm-md hover:bg-gray-200"><a href="#" class="block w-full px-3 py-1">Level</a></li>
                    <li x-on:click="showSideNav = false" class="text-sm rounded-sm-md hover:bg-gray-200"><a href="#" class="block w-full px-3 py-1">Ruangan</a></li>
                </ul>
            </section>
        </div>
    </div>
</nav> --}}

{{-- desktop sidenav --}}
<nav class="flex sticky inset-y-0 left-0 h-screen flex-col text-nowrap overflow-hidden transition-all shadow-inner-2 bg-gray-100">
    <div class="w-64 h-14 border-b flex flex-row justify-center items-center px-3 py-1">
        <img src="{{ asset('images/logoGLC.png') }}" alt="LogoUPBG" class="h-full">
        {{-- <button type="button" class="flex flex-row justify-center items-center text-2xl text-upbg rounded-full size-10 transition hover:bg-gray-200"><i class="fa-solid fa-xmark"></i></i></button> --}}
    </div>
    <div class="flex-1 w-64 flex flex-col gap-3 px-3 py-4">
        <section class="flex flex-col">
            <h1 class="font-semibold text-base">Kelas</h1>
            <ul class="my-1 flex flex-col gap-1">
                <li class="text-sm rounded-sm-md @if(request()->routeIs('kelas.index')) bg-upbg text-white font-medium @else hover:bg-gray-200 @endif"><a href="{{ route('kelas.index') }}" class="block w-full px-3 py-1">Daftar Kelas</a></li>
            </ul>
        </section>
        <section class="flex flex-col">
            <h1 class="font-semibold text-base">User</h1>
            <ul class="my-1 flex flex-col gap-1">
                <li class="text-sm rounded-sm-md @if(request()->routeIs('user.index')) bg-upbg text-white font-medium @else hover:bg-gray-200 @endif"><a href="{{ route('user.index') }}" class="block w-full px-3 py-1">Daftar User</a></li>
                <li class="text-sm rounded-sm-md @if(request()->routeIs('peserta.index')) bg-upbg text-white font-medium @else hover:bg-gray-200 @endif"><a href="{{ route('peserta.index') }}" class="block w-full px-3 py-1">Daftar Peserta</a></li>
            </ul>
        </section>
        <section class="flex flex-col">
            <h1 class="font-semibold text-base">Kelola Kelas</h1>
            <ul class="my-1 flex flex-col gap-1">
                <li class="text-sm rounded-sm-md @if(request()->routeIs('program-kelas.index')) bg-upbg text-white font-medium @else hover:bg-gray-200 @endif"><a href="{{ route('program-kelas.index') }}" class="block w-full px-3 py-1">Program</a></li>
                <li class="text-sm rounded-sm-md @if(request()->routeIs('tipe-kelas.index')) bg-upbg text-white font-medium @else hover:bg-gray-200 @endif"><a href="{{ route('tipe-kelas.index') }}" class="block w-full px-3 py-1">Tipe</a></li>
                <li class="text-sm rounded-sm-md @if(request()->routeIs('level-kelas.index')) bg-upbg text-white font-medium @else hover:bg-gray-200 @endif"><a href="{{ route('level-kelas.index') }}" class="block w-full px-3 py-1">Level</a></li>
                <li class="text-sm rounded-sm-md @if(request()->routeIs('ruangan.index')) bg-upbg text-white font-medium @else hover:bg-gray-200 @endif"><a href="{{ route('ruangan.index') }}" class="block w-full px-3 py-1">Ruangan</a></li>
            </ul>
        </section>
    </div>
</nav>

@push('script')
    <script src="{{ asset('js/views/components/layouts/side-nav.js') }}"></script>
@endpush