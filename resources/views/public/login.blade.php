<x-layouts.public-layout>
    <x-slot:title>UPBG | Login</x-slot>
    <div class="size-full flex flex-col justify-center items-center">
        <div class="login-container w-full max-w-md px-6 flex flex-col justify-center items-center gap-10 translate-y-4 opacity-0 transition duration-1000">
            <h1 class="w-fit font-bold text-4xl text-upbg relative after:w-full after:h-1 after:bg-gradient-to-r after:from-upbg-light after:to-upbg-dark after:absolute after:-bottom-3 after:left-0">Login</h1>
            <p class="text-gray-400 text-center">Selamat datang! Silahkan login menggunakan kredensial yang diberikan admin.</p>
            <form action="{{ route('auth.handleLoginRequest') }}" method="POST" class="flex flex-col w-full gap-8">
                @csrf
                <div class="flex flex-col">
                    <input type="email" name="email" value="{{ old('email') }}" class="p-2 border-b outline-none" placeholder="Email">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <div x-data="{ showPassword: false }" class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full py-2 pl-2 pr-8 border-b outline-none" placeholder="Password">
                        <button type="button" x-on:click="showPassword = !showPassword" class="absolute top-1/2 transform -translate-y-1/2 right-2 text-gray-600">
                            <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="w-5"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="button-style button-upbg-solid"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</button>
            </form>
        </div>
    </div>

    {{-- @pushOnce('script') --}}
        <script src="{{ asset('js/views/guest/login.js') }}"></script>
    {{-- @endPushOnce --}}
</x-layouts.public-layout>