<nav class="sticky top-0 w-full h-14 flex flex-row justify-center z-10 bg-white shadow-sm">
    <div class="flex flex-row justify-between w-full max-w-7xl h-full py-1 px-6">
        @auth
            <a href="{{ route('kelas.index') }}" class="lg:hidden">
                <img src={{ asset('images/logoGLC.png') }} alt="Logo UPBG" class="h-full">
            </a>
            <div x-data="{ showDropdown: false, showRoles: false }" x-on:click.outside="showDropdown = false; showRoles = false" class="flex flex-row ml-auto h-full items-center relative">
                <button x-on:click="showDropdown = !showDropdown; if (!showDropdown) showRoles = false" class="h-full p-0.5 rounded-full transition hover:bg-gray-200">
                    <img src="https://placehold.co/400" class="h-full rounded-full">
                </button>
                <ul x-cloak x-show="showDropdown" class="absolute -bottom-2 right-0 translate-y-full bg-white border shadow-strong w-72 rounded-md">
                    <li class="w-full hover:bg-gray-100">
                        <a href="#" class="flex flex-row p-3 items-center gap-2 w-full">
                            <img src="https://placehold.co/400" class="size-14 rounded-full">
                            <div class="flex-1 flex flex-col justify-center overflow-hidden">
                                <span class="text-sm font-semibold truncate text-upbg">{{ auth()->user()->name }}</span>
                                <span class="text-sm text-gray-400 truncate">{{ auth()->user()->email }}</span>
                            </div>
                        </a>
                    </li>
                    <li><hr></li>
                    <li class="w-full text-sm">
                        <form action="#" method="POST">
                            @csrf
                            <button type="button" x-on:click="showRoles = !showRoles" class="hover:bg-gray-100 flex flex-row p-3 items-center gap-3 w-full">
                                <i class="fa-solid fa-repeat"></i>
                                <span>Role : {{ auth()->user()->currentRole->nama }}</span>
                                <i :class="showRoles ? 'rotate-180' : ''" class="fa-solid fa-angle-down ml-auto transition duration-300"></i>
                            </button>
                            <ul 
                                x-show="showRoles"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="max-h-0"
                                x-transition:enter-end="max-h-96"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="max-h-96"
                                x-transition:leave-end="max-h-0"
                                class="overflow-hidden transition-all duration-300 shadow-inner-2">
                                @foreach (auth()->user()->roles as $role)
                                    <li class="w-full hover:bg-gray-100 text-sm">
                                        <form action="{{ route('auth.switchRole') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            <button type="submit" class="w-full p-3 text-left border-l-4 @if($role->id == auth()->user()->current_role_id) border-upbg @else border-transparent @endif" value="{{ $role->id }}">{{ $role->nama }}</button>
                                        </form>
                                    </li>                                
                                @endforeach
                            </ul>
                        </form>
                    </li>
                    <li class="w-full hover:bg-gray-100">
                        <form action="{{ route('auth.handleLogoutRequest') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex flex-row p-3 items-center gap-3 font-medium text-sm w-full text-red-600">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <img src="{{ asset('images/logoGLC.png') }}" alt="Logo UPBG" class="h-full">
            <ul class="nav-menu-container flex flex-row items-center gap-3 text-upbg text-base font-medium">
                <li class=""><a href="#">Jadwal</a></li>
                <li class="text-lg select-none">|</li>
                <li class="{{ request()->routeIs('auth.loginPage') ? 'topbar-active' : '' }}"><a href="{{ route('auth.loginPage') }}">Login</a></li>
            </ul>
        @endauth
    </div>
</nav>