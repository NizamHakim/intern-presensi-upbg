<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>{{ $tes->kode }}</x-slot>
    <x-slot:sidenav>
        <x-layouts.navgroup title="{{ $tes->kode }}">
            <x-layouts.navlink href="{{ route('tes.detail', ['slug' => $tes->slug]) }}" routeName="tes.detail">Detail Tes</x-layouts.navlink>
        </x-layouts.navgroup>
        <hr>
    </x-slot>

    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="page-title">Detail Tes</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <section id="detail-tes" class="flex flex-col gap-6 bg-white shadow-sm mt-6 p-6 md:flex-row md:justify-between">
        <div class="flex flex-col gap-6">
            <h2 class="text-gray-700 font-semibold text-xl md:text-2xl">{{ $tes->kode }}</h2>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-1">Status:</h3>
                @if ($tes->terlaksana)
                    <span class="text-green-600 font-semibold">Terlaksana</span>
                @else
                    @if (now()->isAfter($tes->waktu_selesai))
                        <span class="text-red-600 font-semibold">Tidak Terlaksana</span>
                    @else
                        <span class="text-gray-600 font-semibold">-</span>
                    @endif
                @endif
            </div>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-1">Pengawas:</h3>
                <ul class="list-none">
                    @foreach ($tes->pengawas as $pengawas)
                        <li><a href="{{ route('user.detail', ['id' => $pengawas->id]) }}" class="underline decoration-transparent text-upbg transition hover:decoration-upbg">{{ $pengawas->nama }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-2">Jadwal:</h3>
                <div class="flex flex-col gap-2 text-gray-700">
                    <p><i class="fa-solid fa-calendar-days mr-2"></i>{{ $tes->tanggal->isoFormat('dddd, D MMMM YYYY') }}</p>
                    <p><i class="fa-regular fa-clock mr-2"></i>{{ $tes->waktu_mulai->isoFormat("HH:mm") }} - {{ $tes->waktu_selesai->isoFormat("HH:mm") }}</p>
                </div>
            </div>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-1">Ruangan:</h3>
                <span class="text-gray-700"><i class="fa-regular fa-building mr-2"></i>{{ $tes->ruangan->kode }}</span>
            </div>
        </div>
        @if (auth()->user()->current_role_id == 4)
            <div class="flex flex-col gap-2 h-fit md:flex-row">
                <a href="{{ route('tes.edit', ['slug' => $tes->slug]) }}" class="button-style button-upbg-outline text-center"><i class="fa-regular fa-pen-to-square mr-1"></i>Edit</a>
                <button type="button" class="delete-tes button-style button-red-outline"><i class="fa-regular fa-trash-can mr-1"></i>Delete</button>
            </div>
        @endif
        <x-ui.modal id="delete-tes-modal">
            <form action="{{ route('tes.destroy', ['slug' => $tes->slug]) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('DELETE')
                <h1 class="modal-title">Hapus Tes</h1>
                <hr class="w-full">
                <p class="text-gray-700">Apakah anda yakin ingin menghapus tes <span class="kode-kelas font-bold">{{ $tes->kode }}</span></p>
                <div class="danger-container flex flex-col gap-2">
                    <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
                    <p>Semua data tes ini akan dihapus permanen</p>
                </div>
                <hr class="w-full">
                <div class="flex flex-row justify-end gap-4">
                    <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                    <button type="submit" class="submit-button button-style border-red-600 bg-red-600 text-white hover:bg-red-700">Delete</button>
                </div>
            </form>
        </x-ui.modal>
    </section>

    <section id="daftar-presensi" class="flex flex-col shadow-sm mt-6">
        <div class="flex flex-col bg-white p-6 gap-6 md:flex-row md:justify-between">
            <div class="flex flex-col items-center gap-2 md:items-start">
                <p class="text-lg text-gray-700 md:text-2xl">Kehadiran Peserta</p>
                <p class="hadir-count text-3xl text-gray-700 font-semibold md:text-4xl">{{ $tes->hadirCount }} / {{ $tes->peserta->count() }}</p>
            </div>
            <div class="flex flex-col gap-2 justify-center">
                <form action="" class="tandai-semua-hadir w-full flex flex-col min-w-[195px]">
                    <button type="submit" class="button-style button-green-outline"><i class="fa-regular fa-square-check mr-1"></i>Tandai Semua Hadir</button>
                </form>
            </div>
        </div>
        
        <div class="presensi-container flex flex-col border-t divide-y bg-white">
            <div class="presensi-header py-2 flex flex-row items-center sm:py-4">
                <p class="w-12 text-gray-600 font-semibold tracking-wide text-center sm:w-20 sm:px-6">No.</p>
                <p class="flex-1 px-2 text-gray-600 font-semibold tracking-wide text-left">Peserta</p>
                <p class="flex-1 min-w-24 text-gray-600 font-semibold tracking-wide text-center md:text-left">Status Kehadiran</p>
            </div>
            @foreach ($tes->peserta as $peserta)
                <div class="presensi-item flex flex-row items-center py-5" data-presensi-id="{{ $peserta->id }}">
                    <p class="w-12 text-center font-medium sm:w-20 sm:px-6">{{ $loop->iteration }}.</p>
                    <div class="flex-1 px-2 flex flex-col">
                        <p class="nama-peserta w-fit font-medium text-gray-700">{{ $peserta->nama }}</p>
                        <p class="nik-peserta w-fit text-gray-600">{{ $peserta->nik }}</p>
                    </div>
                    <form action="" class="form-toggle-kehadiran flex-1 min-w-24 flex flex-row justify-center gap-2 md:justify-start">
                        @if ($peserta->hadir)
                            <button type="submit" name="hadir" value="1" class="button-hadir active">H</button>
                            <button type="submit" name="hadir" value="0" class="button-alfa border">A</button>
                        @else
                            <button type="submit" name="hadir" value="1" class="button-hadir">H</button>
                            <button type="submit" name="hadir" value="0" class="button-alfa active">A</button>
                        @endif
                    </form>
                </div>
            @endforeach
        </div>
    </section>

    @pushOnce('script')
        
    @endPushOnce
</x-layouts.user-layout>