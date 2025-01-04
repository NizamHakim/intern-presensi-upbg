<nav class="sticky top-0 z-10 flex h-14 w-full flex-row justify-center bg-white shadow-sm">
  @if (auth()->check())
    @if (auth()->user()->current_role_id != null)
      <div class="flex h-14 max-w-7xl flex-1 items-center justify-between px-6 py-1 lg:justify-end">
        <button class="open-sidenav size-6 lg:hidden">
          <div class="relative h-0.75 w-4 bg-upbg before:absolute before:left-0 before:top-2 before:h-0.75 before:w-2 before:rounded-full before:bg-upbg after:absolute after:bottom-2 after:left-0 after:h-0.75 after:w-6 after:rounded-full after:bg-upbg"></div>
        </button>
        <a href="/" class="translate-x-2 lg:hidden"><img src={{ asset('images/logoGLC.png') }} alt="Logo UPBG" class="h-12 w-auto"></a>
        <div class="relative flex h-14 items-center">
          <div class="hidden lg:mr-4 lg:flex lg:flex-col lg:items-end lg:gap-1">
            <p class="text-sm font-medium leading-none text-upbg">{{ auth()->user()->nama_panggilan }}</p>
            <p class="text-sm font-medium leading-none text-gray-600">{{ auth()->user()->currentRole->nama }}</p>
          </div>
          <button type="button" class="toggle-profile-menu flex size-12 items-center justify-center rounded-full transition hover:bg-gray-200">
            <img src="{{ auth()->user()->profile_picture }}" class="size-11 rounded-full">
          </button>
          <div class="profile-menu absolute right-0 top-full hidden w-72 -translate-y-1 flex-col divide-y rounded-md border bg-white opacity-0 shadow-lg transition-all">
            <a href="#" class="flex items-center gap-4 rounded-t-md p-3 transition hover:bg-gray-100">
              <img src="{{ auth()->user()->profile_picture }}" class="size-12 rounded-full">
              <div class="flex flex-1 flex-col justify-center truncate">
                <p class="truncate text-sm font-semibold text-upbg">{{ auth()->user()->nama }}</p>
                <p class="truncate text-sm text-gray-400">{{ auth()->user()->email }}</p>
              </div>
            </a>
            <button type="button" class="switch-role-toggle flex items-center justify-between bg-white px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">
              <span><i class="fa-solid fa-repeat mr-2"></i>Role : {{ auth()->user()->currentRole->nama }}</span>
              <i class="fa-solid fa-chevron-down transform text-xs transition"></i>
            </button>
            <form id="switch-role-dropdown" action="{{ route('auth.switchRole') }}" method="POST" class="switch-role-dropdown hidden max-h-0 flex-1 flex-col overflow-y-hidden text-sm font-medium text-gray-600 shadow-inner-2 transition-all">
              @csrf
              @method('PATCH')
              @foreach (auth()->user()->roles as $role)
                <button type="submit" class="px-4 py-3 text-left hover:bg-gray-100" name="role-id" value="{{ $role->id }}">{{ $role->nama }}</button>
              @endforeach
            </form>
            <form action="{{ route('auth.handleLogoutRequest') }}" method="POST" class="flex flex-1 flex-col">
              @csrf
              <button type="submit" class="flex items-center justify-between rounded-b-md bg-white px-4 py-3 text-sm font-medium text-red-600 hover:bg-gray-100">
                <span><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>Logout</span>
              </button>
            </form>
          </div>
        </div>
      </div>
      @pushOnce('script')
        <script src="{{ asset('js/views/components/layouts/top-bar.js') }}"></script>
      @endPushOnce
    @else
      <div class="flex h-14 max-w-7xl flex-1 items-center justify-between px-6 py-1">
        <img src="{{ asset('images/logoGLC.png') }}" alt="Logo UPBG" class="h-12 w-auto">
        <form action="{{ route('auth.handleLogoutRequest') }}" method="POST">
          @csrf
          <button type="submit" class="flex w-fit items-center rounded-md bg-white px-4 py-3 text-sm font-medium text-red-600 hover:bg-gray-100">
            <span><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>Logout</span>
          </button>
        </form>
      </div>
    @endif
  @else
    <div class="flex h-14 max-w-7xl flex-1 items-center justify-between px-6 py-1">
      <img src="{{ asset('images/logoGLC.png') }}" alt="Logo UPBG" class="h-12 w-auto">
      <div class="flex items-center gap-2">
        @php
          $active = request()->routeIs('jadwal.index') ? 'font-semibold' : 'font-normal';
        @endphp
        <a href="{{ route('jadwal.index') }}" class="{{ $active }} tracking-wider text-upbg transition hover:text-upbg-light">Jadwal</a>
        <span class="select-none text-xl text-upbg">|</span>
        @php
          $active = request()->routeIs('auth.loginPage') ? 'font-semibold' : 'font-normal';
        @endphp
        <a href="{{ route('auth.loginPage') }}" class="{{ $active }} tracking-wider text-upbg transition hover:text-upbg-light">Login</a>
      </div>
    </div>
  @endif
</nav>
