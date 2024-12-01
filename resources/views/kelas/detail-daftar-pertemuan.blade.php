<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>{{ $kelas->kode }}</x-slot>
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-[2rem]">Detail Kelas</h1>
        </div>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <div id="detail-kelas">
        <div class="flex flex-row justify-between shadow-sm mt-6 p-8 bg-white">
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
        <a href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" class="bg-white text-upbg px-10 py-2 border-2 font-semibold border-x-gray-300 border-t-gray-300 border-b-white z-[2]">Daftar Pertemuan</a>
        <a href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" class="bg-white text-upbg px-10 py-2 border-2 border-x-gray-300 border-t-gray-300 border-b-gray-300 underline decoration-transparent hover:decoration-upbg transition duration-300">Daftar Peserta</a>
    </nav>
    
    <div id="daftar-pertemuan" class="mb-20">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-2xl">Daftar Pertemuan</h1>
            <button type="button" class="tambah-pertemuan bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-sm px-4 py-2 font-medium text-white rounded-md">
                <i class="fa-solid fa-plus mr-1"></i>
                <span>Tambah Pertemuan</span>
            </button>
            <x-ui.modal id="tambah-pertemuan-modal">
                <h1 class="text-center text-gray-800 text-2xl font-bold">Tambah Pertemuan</h1>
                <form action="{{ route('kelas.pertemuan.store', ['slug' => $kelas->slug]) }}" class="w-112 flex flex-col gap-4">
                    <x-inputs.date inputName="tanggal" label="Tanggal" placeholder="Pilih tanggal"/>
                    <div class="flex flex-row items-start gap-4">
                        <x-inputs.time inputName="waktu-mulai" label="Waktu mulai" placeholder="Pilih waktu mulai"/>
                        <x-inputs.time inputName="waktu-selesai" label="Waktu selesai" placeholder="Pilih waktu selesai"/>
                    </div>
                    <x-inputs.dropdown :selected="$ruanganSelected" :options="$ruanganOptions" inputName="ruangan-kode" label="Pilih ruangan" placeholder="Pilih ruangan"/>
                    <div class="flex flex-row justify-end gap-4 mt-6">
                        <button type="button" class="cancel-button px-8 py-2 text-gray-600 bg-white transition duration-300 hover:bg-gray-100 font-medium rounded-sm-md">Cancel</button>
                        <button type="submit" class="submit-button px-8 py-2 bg-green-600 transition duration-300 hover:bg-green-700 text-white font-medium rounded-sm-md">Tambah</button>
                    </div>
                </form>
            </x-ui.modal>
        </div>
        <table class="w-full table-fixed hidden lg:table mt-6">
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
                                <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="bg-white border px-4 py-2 rounded-md text-sm text-gray-600 block overflow-hidden group hover:text-upbg">
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

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/detail-daftar-pertemuan.js') }}"></script>
    @endpush
</x-layouts.user-layout>