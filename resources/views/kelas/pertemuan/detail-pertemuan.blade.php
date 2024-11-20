<x-layouts.user-layout>
    <x-slot:title>Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</x-slot>
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <div id="detail-pertemuan">
        <div class="flex flex-row justify-between shadow-strong mt-6 p-8">
            <div class="flex flex-col gap-8">
                <h2 class="font-semibold text-2.5xl">Pertemuan ke - {{ $pertemuan->pertemuan_ke }}</h2>
                <div class="flex flex-col">
                    <h3 class="font-semibold text-sm text-gray-800 mb-1">Status:</h3>
                    @if ($pertemuan->terlaksana)
                        <span class="text-green-600 font-semibold">Terlaksana</span>
                    @else
                        @if (now()->isAfter($pertemuan->waktu_selesai))
                            <span class="text-red-600 font-semibold">Tidak Terlaksana</span>
                        @else
                            <span class="text-gray-800 font-semibold">-</span>
                        @endif
                    @endif
                </div>
                <div class="flex flex-col">
                    <h3 class="font-semibold text-sm text-gray-800 mb-1">Pengajar:</h3>
                    @if ($pertemuan->pengajar_id)
                        <a href="{{ route('user.detail', ['id' => $pertemuan->pengajar->id]) }}" class="underline decoration-transparent text-gray-800 transition hover:text-upbg hover:decoration-upbg">{{ $pertemuan->pengajar->nama }}</a>
                    @else
                        <span class="text-gray-800 font-semibold">-</span>
                    @endif
                </div>
                <div class="flex flex-col">
                    <h3 class="font-semibold text-sm text-gray-800 mb-2">Jadwal:</h3>
                    <div class="flex flex-col gap-3 text-gray-800">
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
                </div>
            </div>
            <div class="flex flex-col justify-between items-end">
                <div class="flex flex-col gap-2">
                    <a href="#" class="bg-white text-sm border px-4 py-2 rounded-md text-gray-800 overflow-hidden group text-center hover:text-upbg">
                        <span class="inline-block font-medium translate-x-3 transition duration-300 group-hover:translate-x-0 leading-none">Reschedule</span>
                        <i class="fa-regular fa-calendar-check ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
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
                    <p class="text-2xl text-gray-800">Kehadiran Partisipan</p>
                    <p class="text-5xl font-semibold">{{ $kelas->progress }} / {{ $kelas->banyak_pertemuan }}</p>
                </div>
            </div>
        </div>
    </div>
    <hr class="bg-gray-200 my-10">

    <div class="flex flex-col items-center shadow-strong mt-6 p-8 gap-6">
        <p class="text-gray-600">Mulai pertemuan untuk membuat daftar kehadiran</p>
        <form action="#" method="POST">
            @csrf
            <button @if(now()->isBefore($pertemuan->waktuMulai)) disabled @endif type="button" class="border px-6 py-2 rounded-md bg-upbg text-white font-medium transition duration-300 hover:bg-upbg-dark disabled:opacity-70 disabled:hover:bg-upbg">Mulai Pertemuan</button>
        </form>
        @if(now()->isBefore($pertemuan->waktuMulai))
        <p class="countdown-label text-gray-600 text-center">Pertemuan dapat dimulai dalam,<br><span data-waktu-mulai="{{ $pertemuan->waktu_mulai }}" class="countdown text-upbg font-semibold">0d 0h 0m 0s</span></p>
        @endif
    </div>
    
    <hr class="bg-gray-200 my-10">

    <div class="flex flex-col">
        <div class="flex flex-row justify-end gap-4">
            <button type="button" class="group overflow-hidden text-green-600 text-sm border border-green-600 rounded-md px-4 py-2 bg-white">
                <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover:translate-x-0">Tandai Semua Hadir</span>
                <i class="fa-regular fa-square-check ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
            </button>
            <button type="button" class="bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-sm px-4 py-2 font-medium text-white rounded-md">
                <i class="fa-solid fa-plus mr-1"></i>
                <span>Tambah Partisipan</span>
            </button>
        </div>
        <table class="w-full table-fixed hidden lg:table shadow-strong mt-6">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="w-20 px-6 py-4 text-gray-600 font-semibold tracking-wide text-center">No.</th>
                    <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Partisipan</th>
                    <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Status Kehadiran</th>
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
                                <form action="#" method="POST" class="flex flex-row gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" value="1" class="border rounded-full size-10 bg-white">H</button>
                                    <button type="button" value="0" class="border border-red-600 rounded-full size-10 bg-red-600 text-white font-semibold">A</button>
                                </form>
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

    @push('script')
        <script src="{{ asset('js/utils/countdown.js') }}"></script>
    @endpush
</x-layouts.user-layout>