<x-layouts.user-layout>
    <x-slot:title>{{ $kelas->kode }}</x-slot>
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <div class="flex flex-row mt-8 gap-6 mb-20">
        <div class="flex-1 flex flex-col gap-10">
            <div id="detail-kelas">
                <h1 class="font-bold text-upbg text-2xl">Detail Kelas</h1>
                <div class="flex flex-row justify-between shadow-strong mt-6 p-8">
                    <div class="flex flex-col gap-6">
                        <h2 class="font-semibold text-2.5xl">{{ $kelas->kode }}</h2>
                        <div class="flex flex-col">
                            <h3 class="font-semibold text-sm text-gray-800 mb-1">Pengajar:</h3>
                            <ul class="list-none">
                                @foreach ($kelas->pengajar as $pengajar)
                                    <li><a href="{{ route('user.detail', ['id' => $pengajar->id]) }}" class="underline decoration-transparent text-gray-800 transition hover:text-upbg hover:decoration-upbg">{{ $pengajar->nama }}</a></li>
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
                    <div class="flex flex-col justify-between items-end">
                        <div class="flex flex-col gap-2">
                            <a href="#" class="bg-white text-sm border px-4 py-1.5 rounded-md text-gray-800 overflow-hidden group text-center">
                                <span class="inline-block font-medium translate-x-3 transition duration-300 group-hover:translate-x-0 leading-none">Edit</span>
                                <i class="fa-regular fa-pen-to-square ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
                            </a>
                            <form action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block group overflow-hidden w-full text-red-600 text-sm border rounded-md px-4 py-2 bg-white">
                                    <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover:translate-x-0">Delete</span>
                                    <i class="fa-regular fa-trash-can ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0""></i>
                                </button>
                            </form>
                        </div>
                        <div class="flex flex-col gap-3 items-end">
                            <p class="text-2xl text-gray-800">Pertemuan Terlaksana</p>
                            <p class="text-5xl font-semibold">{{ $kelas->progress }} / {{ $kelas->banyak_pertemuan }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="bg-gray-200 mt-1">
            <div id="daftar-pertemuan">
                <div class="flex flex-row justify-between items-center">
                    <h1 class="font-bold text-upbg text-2xl">Daftar Pertemuan</h1>
                    <button type="button" class="bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-sm px-4 py-2 font-medium text-white rounded-md">
                        <i class="fa-solid fa-plus mr-1"></i>
                        <span>Tambah Pertemuan</span>
                    </button>
                </div>
                <table class="w-full table-fixed hidden lg:table mt-6 shadow-strong">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="w-40 py-4 text-gray-600 font-semibold tracking-wide text-center">Pertemuan ke-</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Jadwal</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Pengajar</th>
                            <th class="w-52 px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Status</th>
                            <th class="w-36 px-4 py-4 text-gray-600 font-semibold tracking-wide text-left"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($kelas->pertemuan->isEmpty())
                            <tr>
                                <td class="px-6 py-4 text-center font-medium text-gray-400" colspan="5">Kelas ini belum punya pertemuan</td>
                            </tr>
                        @else
                            @foreach ($kelas->pertemuan as $pertemuan)
                                <tr class="bg-white transition hover:bg-gray-100">
                                    <td class="py-6 text-center">
                                        <span class="text-2xl font-semibold text-gray-600">{{ $pertemuan->pertemuan_ke }}</span>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex flex-col gap-2 text-gray-800">
                                            <div class="flex flex-row gap-2">
                                                <i class="fa-solid fa-calendar-days w-4"></i>
                                                <span class="leading-none">{{ $pertemuan->tanggal->isoFormat('dddd, D MMMM YYYY')}}</span>
                                            </div>
                                            <div class="flex flex-row gap-2">
                                                <i class="fa-regular fa-clock text-sm w-4"></i>
                                                <span class="leading-none">{{ $pertemuan->waktu_mulai->isoFormat("HH:mm") . " - " . $pertemuan->waktu_selesai->isoFormat("HH:mm") }}</span>
                                            </div>
                                            <div class="flex flex-row gap-2">
                                                <i class="fa-regular fa-building w-4"></i>
                                                <span class="leading-none">{{ $pertemuan->ruangan->kode }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="text-base text-gray-800">{{ ($pertemuan->pengajar_id) ? $pertemuan->pengajar->nama : '-' }}</span>
                                    </td>
                                    <td class="px-6 py-6">
                                        @if ($pertemuan->terlaksana)
                                            <span class="text-green-600 font-semibold">Terlaksana</span>
                                        @else
                                            @if (now()->isAfter($pertemuan->waktu_selesai))
                                                <span class="text-red-600 font-semibold">Tidak Terlaksana</span>
                                            @else
                                                <span class="text-gray-800 font-semibold">-</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="bg-white border px-4 py-2 rounded-md text-sm text-gray-600 block overflow-hidden group hover:text-upbg hover:shadow-md">
                                            <span class="inline-block font-medium translate-x-3 transition duration-300 group-hover:translate-x-0">View</span>
                                            <i class="fa-solid fa-circle-arrow-right ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <hr class="bg-gray-200 mt-1">
            <div id="daftar-partisipan">
                <div class="flex flex-row justify-between items-center">
                    <h1 class="font-bold text-upbg text-2xl">Daftar Partisipan</h1>
                    <button type="button" class="bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-sm px-4 py-2 font-medium text-white rounded-md">
                        <i class="fa-solid fa-plus mr-1"></i>
                        <span>Tambah Partisipan</span>
                    </button>
                </div>
                <table class="w-full table-fixed hidden lg:table mt-6 shadow-strong">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="w-20 px-6 py-4 text-gray-600 font-semibold tracking-wide text-center">No.</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Partisipan</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Occupation</th>
                            <th class="w-44 px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Tanggal Bergabung</th>
                            <th class="w-40 px-6 py-4 text-gray-600 font-semibold tracking-wide text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($kelas->peserta->isEmpty())
                            <tr>
                                <td class="px-6 py-4 text-center font-medium text-gray-400" colspan="3">Kelas ini belum punya peserta</td>
                            </tr>
                        @else
                            @foreach ($kelas->peserta as $peserta)
                                <tr class="bg-white transition hover:bg-gray-100">
                                    <td class="px-6 py-6 text-center">
                                        <span class="text-gray-800 font-medium text-lg">{{ $loop->iteration }}.</span>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex flex-col">
                                            <a href="#" class="font-medium underline decoration-transparent text-gray-800 transition hover:text-upbg hover:decoration-upbg">{{ $peserta->nama }}</a>
                                            <p class="text-sm text-gray-600">{{ $peserta->nik }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="text-gray-800">{{ $peserta->occupation }}</span>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="text-gray-800">{{ $peserta->created_at->format('d-m-Y')}}</span>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <form action="#" method="POST" class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block group overflow-hidden w-full text-red-600 text-sm border rounded-md px-3 py-2 bg-white hover:shadow-md">
                                                <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover:translate-x-0">Remove</span>
                                                <i class="fa-regular fa-trash-can ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0""></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <nav class="flex flex-col w-40 sticky top-16 h-screen border-l border-gray-300">
            <a href="#detail-kelas" class="scroll-navlink bg-white py-2 px-4 font-normal border-l-4 border-transparent transition hover:bg-gray-100">Detail Kelas</a>
            <a href="#daftar-pertemuan" class="scroll-navlink bg-white py-2 px-4 font-normal border-l-4 border-transparent transition hover:bg-gray-100">Daftar Pertemuan</a>
            <a href="#daftar-partisipan" class="scroll-navlink bg-white py-2 px-4 font-normal border-l-4 border-transparent transition hover:bg-gray-100">Daftar Partisipan</a>
        </nav>
    </div>

    @push('script')
        <script src="{{ asset('js/views/kelas/detail-kelas.js') }}"></script>
    @endpush
</x-layouts.user-layout>