<x-layouts.public-layout>
  <x-slot:title>UPBG | Login</x-slot>
  <div class="flex size-full flex-col items-center justify-center">
    <div class="login-container flex w-full max-w-md translate-y-4 flex-col items-center justify-center gap-10 px-6 opacity-0 transition duration-1000">
      <h1 class="relative w-fit text-4xl font-bold text-upbg after:absolute after:-bottom-3 after:left-0 after:h-1 after:w-full after:bg-gradient-to-r after:from-upbg-light after:to-upbg-dark">Login</h1>
      <p class="text-center text-gray-400">Selamat datang! Silahkan login menggunakan kredensial yang diberikan admin.</p>
      <form action="{{ route('auth.handleLoginRequest') }}" method="POST" class="flex w-full flex-col gap-4">
        @csrf
        <div class="flex flex-col">
          <input type="email" name="email" value="{{ old('email') }}" class="input-appearance input-outline text-gray-600" placeholder="Email">
          @error('email')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>
        <div class="relative flex flex-col">
          <button type="button" class="toggle-password absolute inset-y-0 right-0 w-9 text-gray-600"><i class="fa-solid fa-eye"></i></button>
          <input type="password" name="password" class="input-appearance input-outline text-gray-600" placeholder="Pasword">
          @error('password')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>
        <button type="submit" class="btn btn-upbg-solid text-sm"><i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Login</button>
      </form>
    </div>
  </div>

  @pushOnce('script')
    <script src="{{ asset('js/views/guest/login.js') }}"></script>
  @endPushOnce
</x-layouts.public-layout>
