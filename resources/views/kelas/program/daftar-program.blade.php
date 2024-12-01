<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Daftar Program</x-slot>
    <div class="flex flex-row justify-between items-center gap-4 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-[2rem]">Daftar Program</h1>
        <a href="{{ route('program-kelas.create') }}" class="bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-sm px-4 py-2 font-medium text-white rounded-md"">
            <i class="fa-solid fa-plus mr-1"></i>
            <span>Tambah Program</span>
        </a>
    </div>

    <table class="w-full table-fixed hidden lg:table shadow-strong">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-3 py-4 xl:w-28 text-gray-600 font-semibold tracking-wide text-center">No</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Program</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Kode</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-center">Status</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-right"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @if ($programList->isEmpty())
                <tr>
                    <td class="px-3 py-4 text-center font-medium text-gray-400" colspan="5">Tidak ada program yang terdaftar</td>
                </tr>
            @else
                @foreach ($programList as $program)
                    <tr class="bg-white group h-20 transition hover:bg-gray-100" data-program-id="{{ $program->id }}">
                        <td class="px-3 py-4 xl:w-28 text-center">
                            <span class="text-gray-600 font-medium">{{ $loop->iteration + ($programList->currentPage() - 1) * $programList->perPage() }}.</span>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col">
                                <span class="nama-program text-gray-600 font-medium">{{ $program->nama }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col">
                                <span class="kode-program text-gray-600 font-medium">{{ $program->kode ? $program->kode : '-' }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            @if ($program->aktif)
                                <span class="status-program bg-green-300 text-green-800 text-sm font-semibold px-2 rounded-full">Aktif</span>
                            @else
                                <span class="status-program bg-red-300 text-red-800 text-sm font-semibold px-2 rounded-full">Tidak aktif</span>
                            @endif
                        </td>
                        <td class="px-8 text-right">
                            <div class="button-container flex flex-row justify-end items-center gap-2">
                                <button class="edit-program bg-white text-sm border px-6 py-2 rounded-md text-gray-800 overflow-hidden text-center group/button hover:text-upbg">
                                    <span class="inline-block font-medium translate-x-3 transition duration-300 group-hover/button:translate-x-0 leading-none">Edit</span>
                                    <i class="fa-regular fa-pen-to-square ml-1 inline-block transition duration-300 translate-x-12 group-hover/button:translate-x-0"></i>
                                </button>
                                <button type="button" class="delete-program overflow-hidden text-red-600 text-sm border rounded-md px-4 py-2 bg-white group/button">
                                    <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover/button:translate-x-0">Delete</span>
                                    <i class="fa-regular fa-trash-can ml-1 inline-block transition duration-300 translate-x-12 group-hover/button:translate-x-0""></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <x-ui.delete-dialog :useSoftDelete="true" :action="route('program-kelas.destroy')" class="delete-program-dialog">
        <x-slot:title>Hapus program?</x-slot>
        <x-slot:message>Apakah anda yakin ingin menghapus program <span class="nama-kode-program font-bold">Nama - kode</span> ?</x-slot>
        <x-slot:softDeleteMessage>
            <p class="text-gray-500">Untuk integritas data, program akan dihapus dari sistem tetapi tetap ada pada database, sehingga:</p>
            <ul class="list-inside list-disc text-gray-500">
                <li>Data legacy dari program ini tetap bisa diakses</li>
                <li>Kode program yang sama tidak bisa digunakan untuk program lain</li>
            </ul>
        </x-slot>
        <x-slot:forceDeleteMessage>
            <p class="text-red-600">Hapus permanen akan menghapus program dari database dan semua data kelas yang terasosiasi dengan program ini!</p>
        </x-slot>
        <x-slot:hiddenInputs>
            <input type="hidden" name="program-id">
        </x-slot>
    </x-ui.delete-dialog>

    <div class="mb-10">
        {{ $programList->onEachSide(2)->links() }}
    </div>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/components/inputs/checkbox.js') }}"></script>
        <script src="{{ asset('js/views/kelas/program/daftar-program.js') }}"></script>
    @endpush
</x-layouts.user-layout>