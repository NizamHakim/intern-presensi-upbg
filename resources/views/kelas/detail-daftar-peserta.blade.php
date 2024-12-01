<x-layouts.user-layout>
    <x-slot:title>{{ $kelas->kode }}</x-slot>
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-[2rem]">Detail Kelas</h1>
        </div>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <div id="detail-kelas">
        <div class="flex flex-row justify-between shadow-strong mt-6 p-8">
            <div class="flex flex-col gap-6">
                <h2 class="font-semibold text-2.5xl">{{ $kelas->kode }}</h2>
                <div class="flex flex-col">
                    <h3 class="font-semibold text-sm text-gray-800 mb-1">Pengajar:</h3>
                    <ul class="list-none">
                        @foreach ($kelas->pengajar as $pengajar)
                            @if (auth()->user()->current_role_id == 2)
                                <li><a href="{{ route('user.detail', ['id' => $pengajar->id]) }}" class="underline decoration-transparent text-gray-800 transition hover:text-upbg hover:decoration-upbg">{{ $pengajar->nama }}</a></li>
                            @elseif (auth()->user()->current_role_id == 3)
                                <li class="text-gray-800">{{ $pengajar->nama }}</li>                            
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="flex flex-col">
                    <h3 class="font-semibold text-sm text-gray-800 mb-1">Jadwal:</h3>
                    @foreach ($kelas->jadwal as $jadwal)
                        <div class="flex flex-row gap-1">
                            <span class=" w-24 text-gray-800"><i class="fa-solid fa-calendar-days mr-2"></i>{{ $jadwal->namaHari }}</span>
                            <span class=" text-gray-800"><i class="fa-regular fa-clock mr-2"></i>{{ $jadwal->waktu_mulai->format('H:i') }} - {{ $jadwal->waktu_selesai->format('H:i') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col">
                    <h3 class="font-semibold text-sm text-gray-800 mb-1">Ruangan:</h3>
                    <span class="text-gray-800"><i class="fa-regular fa-building mr-2"></i>{{ $kelas->ruangan->kode }}</span>
                </div>
            </div>
            <div class="flex flex-col @if (auth()->user()->current_role_id == 2) justify-between @else justify-end @endif items-end">
                @if (auth()->user()->current_role_id == 2)
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('kelas.edit', ['slug' => $kelas->slug]) }}" class="bg-white text-sm border px-4 py-2 rounded-md text-gray-800 overflow-hidden group text-center hover:text-upbg">
                            <span class="inline-block font-medium translate-x-3 transition duration-300 group-hover:translate-x-0 leading-none">Edit</span>
                            <i class="fa-regular fa-pen-to-square ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
                        </a>
                        <button type="button" class="delete-kelas block group overflow-hidden w-full text-red-600 text-sm border rounded-md px-4 py-2 bg-white">
                            <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover:translate-x-0">Delete</span>
                            <i class="fa-regular fa-trash-can ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0""></i>
                        </button>
                        <x-ui.delete-dialog :action="route('kelas.destroy', ['slug' => $kelas->slug])" class="delete-kelas-dialog">
                            <x-slot:title>Hapus kelas?</x-slot>
                            <x-slot:message>Apakah anda yakin ingin menghapus kelas <span class="font-bold">{{ $kelas->kode }}</span> ?</x-slot>
                            <x-slot:deleteMessage>
                                <p class="text-red-600">Semua data untuk kelas ini akan dihapus permanen</p>
                            </x-slot>
                            <x-slot:hiddenInputs>
                                <input type="hidden" name="kelas-slug" value="{{ $kelas->slug }}">
                            </x-slot>
                        </x-ui.delete-dialog>
                    </div>
                @endif
                <div class="flex flex-col gap-3 items-end">
                    <p class="text-2xl text-gray-800">Pertemuan Terlaksana</p>
                    <p class="text-5xl font-semibold">{{ $kelas->progress }} / {{ $kelas->banyak_pertemuan }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="bg-gray-200 my-10">
    <nav class="my-10 flex flex-row items-center gap-2 relative after:absolute after:h-[2px] after:bg-gray-300 after:bottom-0 after:w-full">
        <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="bg-white text-upbg px-10 py-2 border-2 border-x-gray-300 border-t-gray-300 border-b-gray-300 underline decoration-transparent hover:decoration-upbg transition duration-300">Daftar Pertemuan</a>
        <a href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" class="bg-white text-upbg px-10 py-2 border-2 font-semibold border-x-gray-300 border-t-gray-300 border-b-white z-[2]">Daftar Peserta</a>
    </nav>

    <div id="daftar-peserta" class="mb-20">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-2xl">Daftar Peserta</h1>
            <button type="button" class="bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-sm px-4 py-2 font-medium text-white rounded-md">
                <i class="fa-solid fa-plus mr-1"></i>
                <span>Tambah Peserta</span>
            </button>
        </div>
        <table class="w-full table-fixed hidden lg:table mt-6 shadow-strong">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="w-20 px-6 py-4 text-gray-600 font-semibold tracking-wide text-center">No.</th>
                    <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Peserta</th>
                    <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Occupation</th>
                    <th class="w-44 px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Tanggal Bergabung</th>
                    <th class="w-40 px-6 py-4 text-gray-600 font-semibold tracking-wide text-center"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @if ($pesertaList->isEmpty())
                    <tr>
                        <td class="px-6 py-4 text-center font-medium text-gray-400" colspan="5">Kelas ini belum punya peserta</td>
                    </tr>
                @else
                    @foreach ($pesertaList as $peserta)
                        <tr class="bg-white transition hover:bg-gray-100" data-peserta-id="{{ $peserta->id }}">
                            <td class="px-6 py-6 text-center">
                                <span class="text-gray-800 font-medium text-lg">{{ $loop->iteration + ($pesertaList->currentPage() - 1) * $pesertaList->perPage() }}.</span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <a href="#" class="nama-peserta font-medium underline decoration-transparent text-gray-800 transition hover:text-upbg hover:decoration-upbg">{{ $peserta->nama }}</a>
                                    <p class="nik-peserta text-sm text-gray-600">{{ $peserta->nik }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-gray-800">{{ $peserta->occupation }}</span>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-gray-800">{{ $peserta->created_at->format('d-m-Y')}}</span>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <button type="button" class="delete-peserta block group overflow-hidden w-full text-red-600 text-sm border rounded-md px-3 py-2 bg-white hover:shadow-md">
                                    <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover:translate-x-0">Remove</span>
                                    <i class="fa-regular fa-trash-can ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0""></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <x-ui.delete-dialog :action="route('kelas.destroyPeserta', ['slug' => $kelas->slug])" class="delete-peserta-dialog">
            <x-slot:title>Hapus peserta?</x-slot>
            <x-slot:message>Apakah anda yakin ingin menghapus <span class="font-bold nama-nik-user">User</span> dari kelas ini?</x-slot>
            <x-slot:deleteMessage>
                <ul class="list-disc list-inside">
                    <li class="text-red-600">Data presensi peserta ini untuk pertemuan yang sudah terlaksana tidak akan dihapus</li>
                    <li class="text-red-600">Peserta tidak akan secara otomatis diikutkan untuk pertemuan yang akan datang</li>
                </ul>
            </x-slot>
            <x-slot:hiddenInputs>
                <input type="hidden" name="peserta-id" value="">
            </x-slot>
        </x-ui.delete-dialog>
    </div>
    <div class="mb-10">
        {{ $pesertaList->onEachSide(2)->links() }}
    </div>

    @push('script')
        <script src="{{ asset('js/views/kelas/detail-daftar-peserta.js') }}"></script>
    @endpush
</x-layouts.user-layout>