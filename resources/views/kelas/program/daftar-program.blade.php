<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Daftar Program</x-slot>
    <div class="flex flex-row justify-between items-center gap-4 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-[2rem]">Daftar Program</h1>
        <a href="{{ route('program-kelas.create') }}" class="relative text-white font-semibold px-3 py-2 bg-green-600 rounded-md shadow-[0px_3px] shadow-green-700 transition ease-linear transform translate-y-0 cursor-pointer active:shadow-none active:translate-y-1">
            <i class="fa-solid fa-plus mr-2"></i>
            Tambah Program
        </a>
    </div>

    @session('toast')
        <x-ui.toast status="{{ $value['status'] }}">
            {{ $value['message'] }}
        </x-ui.toast>
    @endsession

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
                                <button class="edit-program px-3 py-2 text-gray-800 font-semibold">Edit</button>
                                <span class="text-xl text-gray-400 font-light select-none">|</span>
                                <button class="delete-program px-3 py-2 text-red-600 font-semibold">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <x-ui.delete-dialog :useSoftDelete="true" :action="route('program-kelas.destroy')" inputName="program-id">
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