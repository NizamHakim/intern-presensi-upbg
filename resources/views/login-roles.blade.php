<x-layouts.public-layout>
  <x-slot:title>UPBG | Login</x-slot>
  <section class="flex size-full flex-col items-center justify-center gap-y-8">
    <h1 class="text-xl font-semibold text-upbg">Pilih role untuk melanjutkan!</h1>
    <form action="{{ route('auth.switchRole') }}" method="POST" class="flex w-full flex-wrap justify-center gap-6">
      @csrf
      @method('PATCH')
      @foreach (auth()->user()->roles as $role)
        <button type="submit" class="size-36 rounded-md border bg-white font-medium text-upbg shadow-sm transition hover:bg-gray-100" name="role-id" value="{{ $role->id }}">{{ $role->nama }}</button>
      @endforeach
    </form>
  </section>
</x-layouts.public-layout>
