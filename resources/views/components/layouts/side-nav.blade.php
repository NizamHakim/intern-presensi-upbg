<div class="sidenav-backdrop hidden fixed bg-black bg-opacity-25 inset-0 opacity-0 transition-opacity z-20 lg:block lg:sticky lg:left-0 lg:inset-y-0 lg:h-screen lg:opacity-100 lg:size-fit lg:z-0">
    <nav class="sidenav fixed left-0 -translate-x-full h-screen z-30 bg-white transition-transform lg:flex lg:flex-col lg:z-0 lg:sticky lg:left-0 lg:inset-y-0 lg:h-screen lg:translate-x-0 lg:text-nowrap lg:overflow-hidden lg:shadow-sm">
        <div class="w-64 h-14 flex flex-row justify-center items-center px-3 py-1 shadow-sm">
            <a href="{{ route('kelas.index') }}" class="h-full">
                <img src="{{ asset('images/logoGLC.png') }}" alt="LogoUPBG" class="h-full">
            </a>
        </div>
        <div class="flex-1 w-64 flex flex-col gap-3 px-3 py-6">
            {{ $slot }}
            @if (auth()->user()->current_role_id == 2 || auth()->user()->current_role_id == 3)
                <x-layouts.navgroup title="Kelas">
                    <x-layouts.navlink href="{{ route('kelas.index') }}" routeName="kelas.index">Daftar Kelas</x-layouts.navlink>
                </x-layouts.navgroup>            
            @endif

            @if (auth()->user()->current_role_id == 4 || auth()->user()->current_role_id == 5)
                <x-layouts.navgroup title="Tes">
                    <x-layouts.navlink href="{{ route('tes.index') }}" routeName="tes.index">Daftar Tes</x-layouts.navlink>
                </x-layouts.navgroup>
            @endif
                
            @if (auth()->user()->current_role_id == 2 || auth()->user()->current_role_id == 4)
                <x-layouts.navgroup title="User">
                    <x-layouts.navlink href="{{ route('user.index') }}" routeName="user.index">Daftar User</x-layouts.navlink>
                    <x-layouts.navlink href="{{ route('peserta.index') }}" routeName="peserta.index">Daftar Peserta</x-layouts.navlink>
                </x-layouts.navgroup>
            @endif
            
            @if (auth()->user()->current_role_id == 2)
                <x-layouts.navgroup title="Kelola Kelas">
                    <x-layouts.navlink href="{{ route('program-kelas.index') }}" routeName="program-kelas.index">Program</x-layouts.navlink>
                    <x-layouts.navlink href="{{ route('tipe-kelas.index') }}" routeName="tipe-kelas.index">Tipe</x-layouts.navlink>
                    <x-layouts.navlink href="{{ route('level-kelas.index') }}" routeName="level-kelas.index">Level</x-layouts.navlink>
                    <x-layouts.navlink href="{{ route('ruangan.index') }}" routeName="ruangan.index">Ruangan</x-layouts.navlink>
                </x-layouts.navgroup>
            @endif

            @if (auth()->user()->current_role_id == 4)
                <x-layouts.navgroup title="Kelola Tes">
                    <x-layouts.navlink href="{{ route('ruangan.index') }}" routeName="ruangan.index">Ruangan</x-layouts.navlink>
                </x-layouts.navgroup>
            @endif
                
        </div>
    </nav>
</div>