<nav class="sidenav hidden sticky inset-y-0 left-0 h-screen flex-col text-nowrap overflow-hidden bg-white shadow-sm lg:flex">
    <div class="w-64 h-14 flex flex-row justify-center items-center px-3 py-1 shadow-sm">
        <a href="{{ route('kelas.index') }}" class="h-full">
            <img src="{{ asset('images/logoGLC.png') }}" alt="LogoUPBG" class="h-full">
        </a>
        {{-- <button type="button" class="sidenav-close-button flex flex-row justify-center items-center text-2xl text-upbg rounded-full size-10 transition hover:bg-gray-200"><i class="fa-solid fa-xmark"></i></i></button> --}}
    </div>
    <div class="flex-1 w-64 flex flex-col gap-3 px-3 py-6">
        {{ $slot }}
        @if (auth()->user()->current_role_id == 2 || auth()->user()->current_role_id == 3)
            <x-layouts.navgroup title="Kelas">
                <x-layouts.navlink href="{{ route('kelas.index') }}" routeName="kelas.index">Daftar Kelas</x-layouts.navlink>
            </x-layouts.navgroup>            
        @endif

        @if (auth()->user()->current_role_id == 2)
            <x-layouts.navgroup title="User">
                <x-layouts.navlink href="{{ route('user.index') }}" routeName="user.index">Daftar User</x-layouts.navlink>
                <x-layouts.navlink href="{{ route('peserta.index') }}" routeName="peserta.index">Daftar Peserta</x-layouts.navlink>
            </x-layouts.navgroup>

            <x-layouts.navgroup title="Kelola Kelas">
                <x-layouts.navlink href="{{ route('program-kelas.index') }}" routeName="program-kelas.index">Program</x-layouts.navlink>
                <x-layouts.navlink href="{{ route('tipe-kelas.index') }}" routeName="tipe-kelas.index">Tipe</x-layouts.navlink>
                <x-layouts.navlink href="{{ route('level-kelas.index') }}" routeName="level-kelas.index">Level</x-layouts.navlink>
                <x-layouts.navlink href="{{ route('ruangan.index') }}" routeName="ruangan.index">Ruangan</x-layouts.navlink>
            </x-layouts.navgroup>
        @endif
    </div>
</nav>

@pushOnce('script')
    <script src="{{ asset('js/views/components/layouts/side-nav.js') }}"></script>
@endPushOnce