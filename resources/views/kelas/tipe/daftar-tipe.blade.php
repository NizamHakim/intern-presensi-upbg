<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Daftar Tipe</x-slot>
    <div class="flex flex-row justify-between items-center gap-4 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-[2rem]">Daftar Tipe</h1>
        <a href="{{ route('tipe-kelas.create') }}" class="relative text-white font-semibold px-3 py-2 bg-green-600 rounded-md shadow-[0px_3px] shadow-green-700 transition ease-linear transform translate-y-0 cursor-pointer active:shadow-none active:translate-y-1">
            <i class="fa-solid fa-plus mr-2"></i>
            Tambah Tipe
        </a>
    </div>

    <table class="w-full table-fixed hidden lg:table shadow-strong">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-3 py-4 xl:w-28 text-gray-600 font-semibold tracking-wide text-center">No</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Tipe</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Kode</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-center">Status</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-right"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @if ($tipeList->isEmpty())
                <tr>
                    <td class="px-3 py-4 text-center font-medium text-gray-400" colspan="5">Tidak ada tipe yang terdaftar</td>
                </tr>
            @else
                @foreach ($tipeList as $tipe)
                    <tr class="bg-white group h-20 transition hover:bg-gray-100" data-tipe-id="{{ $tipe->id }}">
                        <td class="px-3 py-4 xl:w-28 text-center">
                            <span class="text-gray-600 font-medium">{{ $loop->iteration + ($tipeList->currentPage() - 1) * $tipeList->perPage() }}.</span>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col">
                                <span class="nama-tipe text-gray-600 font-medium">{{ $tipe->nama }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col">
                                <span class="kode-tipe text-gray-600 font-medium">{{ $tipe->kode ? $tipe->kode : '-' }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            @if ($tipe->aktif)
                                <span class="status-tipe bg-green-300 text-green-800 text-sm font-semibold px-2 rounded-full">Aktif</span>
                            @else
                                <span class="status-tipe bg-red-300 text-red-800 text-sm font-semibold px-2 rounded-full">Tidak aktif</span>
                            @endif
                        </td>
                        <td class="px-8 text-right">
                            <div class="button-container flex flex-row justify-end items-center gap-2">
                                <button class="edit-tipe px-3 py-2 text-gray-800 font-semibold">Edit</button>
                                <span class="text-xl text-gray-400 font-light select-none">|</span>
                                <button class="delete-tipe px-3 py-2 text-red-600 font-semibold">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <x-ui.delete-dialog :useSoftDelete="true" :action="route('tipe-kelas.destroy')" inputName="tipe-id">
        <x-slot:title>Hapus tipe?</x-slot>
        <x-slot:message>Apakah anda yakin ingin menghapus tipe <span class="nama-kode-tipe font-bold">Nama - kode</span> ?</x-slot>
        <x-slot:softDeleteMessage>
            <p class="text-gray-500">Untuk integritas data, tipe akan dihapus dari sistem tetapi tetap ada pada database, sehingga:</p>
            <ul class="list-inside list-disc text-gray-500">
                <li>Data legacy dari tipe ini tetap bisa diakses</li>
                <li>Kode tipe yang sama tidak bisa digunakan untuk tipe lain</li>
            </ul>
        </x-slot>
        <x-slot:forceDeleteMessage>
            <p class="text-red-600">Hapus permanen akan menghapus tipe dari database dan semua data kelas yang terasosiasi dengan tipe ini!</p>
        </x-slot>
    </x-ui.delete-dialog>

    <div class="mb-10">
        {{ $tipeList->onEachSide(2)->links() }}
    </div>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/components/inputs/checkbox.js') }}"></script>
        <script src="{{ asset('js/views/kelas/tipe/daftar-tipe.js') }}"></script>
    @endpush
</x-layouts.user-layout>