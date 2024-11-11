<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Daftar Level</x-slot>
    <div class="flex flex-row justify-between items-center gap-4 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-[2rem]">Daftar Level</h1>
        <a href="{{ route('level-kelas.create') }}" class="relative text-white font-semibold px-3 py-2 bg-green-600 rounded-md shadow-[0px_3px] shadow-green-700 transition ease-linear transform translate-y-0 cursor-pointer active:shadow-none active:translate-y-1">
            <i class="fa-solid fa-plus mr-2"></i>
            Tambah Level
        </a>
    </div>

    <table class="w-full table-fixed hidden lg:table shadow-strong">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-3 py-4 xl:w-28 text-gray-600 font-semibold tracking-wide text-center">No</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Level</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Kode</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-center">Status</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-right"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @if ($levelList->isEmpty())
                <tr>
                    <td class="px-3 py-4 text-center font-medium text-gray-400" colspan="5">Tidak ada level yang terdaftar</td>
                </tr>
            @else
                @foreach ($levelList as $level)
                    <tr class="bg-white group h-20 transition hover:bg-gray-100" data-level-id="{{ $level->id }}">
                        <td class="px-3 py-4 xl:w-28 text-center">
                            <span class="text-gray-600 font-medium">{{ $loop->iteration + ($levelList->currentPage() - 1) * $levelList->perPage() }}.</span>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col">
                                <span class="nama-level text-gray-600 font-medium">{{ $level->nama }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col">
                                <span class="kode-level text-gray-600 font-medium">{{ $level->kode ? $level->kode : '-' }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            @if ($level->aktif)
                                <span class="status-level bg-green-300 text-green-800 text-sm font-semibold px-2 rounded-full">Aktif</span>
                            @else
                                <span class="status-level bg-red-300 text-red-800 text-sm font-semibold px-2 rounded-full">Tidak aktif</span>
                            @endif
                        </td>
                        <td class="px-8 text-right">
                            <div class="button-container flex flex-row justify-end items-center gap-2">
                                <button class="edit-level px-3 py-2 text-gray-800 font-semibold">Edit</button>
                                <span class="text-xl text-gray-400 font-light select-none">|</span>
                                <button class="delete-level px-3 py-2 text-red-600 font-semibold">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <x-ui.delete-dialog :useSoftDelete="true" :action="route('level-kelas.destroy')" inputName="level-id">
        <x-slot:title>Hapus Level?</x-slot>
        <x-slot:message>Apakah anda yakin ingin menghapus level <span class="nama-kode-level font-bold">Nama - kode</span> ?</x-slot>
        <x-slot:softDeleteMessage>
            <p class="text-gray-500">Untuk integritas data, level akan dihapus dari sistem tetapi tetap ada pada database, sehingga:</p>
            <ul class="list-inside list-disc text-gray-500">
                <li>Data legacy dari level ini tetap bisa diakses</li>
                <li>Kode level yang sama tidak bisa digunakan untuk level lain</li>
            </ul>
        </x-slot>
        <x-slot:forceDeleteMessage>
            <p class="text-red-600">Hapus permanen akan menghapus level dari database dan semua data kelas yang terasosiasi dengan level ini!</p>
        </x-slot>
    </x-ui.delete-dialog>

    <div class="mb-10">
        {{ $levelList->onEachSide(2)->links() }}
    </div>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/components/inputs/checkbox.js') }}"></script>
        <script src="{{ asset('js/views/kelas/level/daftar-level.js') }}"></script>
    @endpush
</x-layouts.user-layout>