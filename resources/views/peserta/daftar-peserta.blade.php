<x-layouts.user-layout>
    <x-slot:title>Daftar Peserta</x-slot>
    <h1 class="font-semibold text-upbg text-3xl mb-4">Daftar Peserta</h1>

    <form action="{{ route('peserta.index') }}" method="GET" class="flex flex-row gap-2">
        <x-inputs.categorical-search :options="$searchOptions" :selected="$searchSelected" placeholder="Cari Peserta" value="{{ $searchValue }}"/>
        <button type="submit" class="h-fit self-end bg-upbg transition duration-300 hover:bg-upbg-dark text-white px-3 py-2 rounded-md">
            <span><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</span>
        </button>
    </form>

    <table class="w-full table-fixed hidden lg:table mt-8 shadow-strong">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-3 py-4 lg:w-28 text-gray-600 font-semibold tracking-wide text-center">No</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Peserta</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">Occupation</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @if ($pesertaList->isEmpty())
                <tr>
                    <td class="px-3 py-4 text-center font-medium text-gray-400" colspan="4">Tidak ada peserta yang cocok</td>
                </tr>
            @else
                @foreach ($pesertaList as $peserta)
                    <tr class="bg-white transition hover:bg-gray-100">
                        <td class="px-3 py-4 xl:w-28 text-center">
                            <span class="text-gray-600 font-semibold">{{ $loop->iteration + ($pesertaList->currentPage() - 1) * $pesertaList->perPage() }}.</span>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col justify-center">
                                <a href="#" class="text-upbg underline decoration-transparent transition hover:decoration-upbg font-semibold">{{ $peserta->nama }}</a>
                                <p class="text-gray-400 text-sm font-medium">{{ $peserta->nik }}</p>
                            </div>
                        </td>
                        <td class="px-3 py-4">
                            <span>{{ $peserta->occupation }}</span>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="mb-10">
        {{ $pesertaList->onEachSide(2)->links() }}
    </div>
</x-layouts.user-layout>