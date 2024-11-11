<x-layouts.user-layout>
    <x-slot:title>Daftar Ruangan</x-slot>
    <div class="flex flex-row justify-between items-center gap-4 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-[2rem]">Daftar Ruangan</h1>
    </div>

    <table class="w-full table-fixed hidden lg:table shadow-strong">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-3 py-4 xl:w-28 text-gray-600 font-semibold tracking-wide text-center">No</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Ruangan</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Kapasitas</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @if ($ruanganList->isEmpty())
                <tr>
                    <td class="px-3 py-4 text-center font-medium text-gray-400" colspan="5">Tidak ada ruangan yang terdaftar</td>
                </tr>
            @else
                @foreach ($ruanganList as $ruangan)
                    <tr class="bg-white group h-20 transition hover:bg-gray-100"">
                        <td class="px-3 py-4 xl:w-28 text-center">
                            <span class="text-gray-600 font-medium">{{ $loop->iteration + ($ruanganList->currentPage() - 1) * $ruanganList->perPage() }}.</span>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col">
                                <span class="nama-ruangan text-gray-600 font-medium">{{ $ruangan->kode }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col">
                                <span class="kode-ruangan text-gray-600 font-medium">{{ $ruangan->kapasitas ? $ruangan->kapasitas : '-' }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="mb-10">
        {{ $ruanganList->onEachSide(2)->links() }}
    </div>

    @push('script')

    @endpush
</x-layouts.user-layout>