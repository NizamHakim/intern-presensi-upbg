<x-layouts.user-layout>
    <x-slot:title>Tambah Program</x-slot>
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-[2rem]">Tambah Program</h1>
        </div>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <form id="form-tambah" action="{{ route('program-kelas.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('POST')
        <div class="flex flex-col gap-1">
            <label for="nama-program" class="font-medium text-gray-600">Nama Program</label>
            <input id="nama-program" type="text" name="nama-program" placeholder="Nama Program" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
        </div>
        <div class="flex flex-col gap-1">
            <label for="kode-program" class="font-medium text-gray-600">Kode Program</label>
            <input id="kode-program" type="text" name="kode-program" placeholder="Kode Program" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
        </div>
        <hr class="bg-gray-200 my-5">
        <div class="flex flex-row justify-end items-center gap-4">
            <a href="{{ route('program-kelas.index') }}" class="relative text-center text-gray-600 font-medium px-8 py-2 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-300">Cancel</a>
            <button type="submit" class="bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-base px-8 py-2 font-medium text-white rounded-md">Tambah</button>
        </div>
    </form>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/utils/toast.js') }}"></script>
        <script src="{{ asset('js/views/kelas/program/tambah-program.js') }}"></script>
    @endpush
</x-layouts.user-layout>