<x-layouts.user-layout>
    <x-slot:title>Daftar User</x-slot>
    <h1 class="font-semibold text-upbg text-3xl mb-4">Daftar User</h1>
    <form action="{{ route('user.index') }}" method="GET" class="flex flex-col gap-4">
        <div class="flex flex-row gap-2">
            <div class="w-80">
                <x-inputs.dropdown :options="$roleOptions" :selected="$roleSelected" label="Role" inputName="role"/>
            </div>
            <div class="flex flex-col flex-1">
                <label class="block font-medium text-sm mb-1.5 text-gray-600">Cari Nama</label>
                <input type="search" name="search" placeholder="Cari Nama" class="flex-1 px-3 py-1 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline-none">
            </div>
            <button type="submit" class="h-fit self-end bg-upbg transition duration-300 hover:bg-upbg-dark text-white px-3 py-2 rounded-md">
                <span><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</span>
            </button>
        </div>
    </form>
    
</x-layouts.user-layout>