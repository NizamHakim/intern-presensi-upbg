<x-layouts.user-layout>
    <x-slot:title>Tambah Level</x-slot>
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-[2rem]">Tambah Level</h1>
        </div>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <form id="form-tambah" action="{{ route('level-kelas.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('POST')
        <div class="flex flex-col gap-1">
            <label for="nama-level" class="font-medium text-gray-600">Nama Level</label>
            <input id="nama-level" type="text" name="nama-level" placeholder="Nama Level" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
        </div>
        <div class="flex flex-col gap-1">
            <label for="kode-level" class="font-medium text-gray-600">Kode Level</label>
            <input id="kode-level" type="text" name="kode-level" placeholder="Kode Level" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
        </div>
        <button type="submit" class="relative mt-2 text-white font-semibold px-3 py-2 bg-green-600 rounded-md shadow-[0px_3px] shadow-green-700 transition ease-linear transform translate-y-0 cursor-pointer active:shadow-none active:translate-y-1">Tambah</button>
        <a href="{{ route('level-kelas.index') }}" class="relative text-center text-gray-400 font-semibold border border-gray-400 px-3 py-2 bg-white rounded-md shadow-none transition duration-300 hover:shadow-md">Cancel</a>
    </form>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/level/tambah-level.js') }}"></script>
    @endpush
</x-layouts.user-layout>