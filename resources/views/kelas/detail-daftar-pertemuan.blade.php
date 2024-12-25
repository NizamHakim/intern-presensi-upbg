<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>{{ $kelas->kode }}</x-slot>
    <x-slot:sidenav>
        <x-layouts.navgroup title="{{ $kelas->kode }}">
            <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}"
                routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
            <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}"
                routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
        </x-layouts.navgroup>
        <hr>
    </x-slot>

    <div class="mb-8 mt-6 flex flex-col gap-6">
        <h1 class="page-title">Detail Kelas</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs" />
    </div>

    <section id="detail-kelas" class="mt-6 flex flex-col gap-6 bg-white p-6 shadow-sm md:flex-row md:justify-between">
        <div class="flex flex-col gap-6">
            <h2 class="text-xl font-semibold text-gray-700 md:text-2xl">{{ $kelas->kode }}</h2>
            <div class="flex flex-col">
                <h3 class="mb-1 font-semibold text-gray-700">Pengajar:</h3>
                <ul class="list-none">
                    @foreach ($kelas->pengajar as $pengajar)
                        <li><a href="{{ route('user.detail', ['id' => $pengajar->id]) }}"
                                class="text-upbg underline decoration-transparent transition hover:decoration-upbg">{{ $pengajar->nama }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="flex flex-col">
                <h3 class="mb-2 font-semibold text-gray-700">Jadwal:</h3>
                <div class="flex flex-col gap-2 text-gray-700">
                    @foreach ($kelas->jadwal as $jadwal)
                        <p><i class="fa-solid fa-calendar-days mr-2"></i><span
                                class="mr-2">{{ $jadwal->namaHari }}</span><i
                                class="fa-regular fa-clock mr-2"></i><span>{{ $jadwal->waktu_mulai->format('H:i') }} -
                                {{ $jadwal->waktu_selesai->format('H:i') }}</span></p>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col">
                <h3 class="mb-1 font-semibold text-gray-700">Ruangan:</h3>
                <span class="text-gray-700"><i
                        class="fa-regular fa-building mr-2"></i>{{ $kelas->ruangan->kode }}</span>
            </div>
            <div class="flex flex-col">
                <h3 class="mb-1 font-semibold text-gray-700">WhatsApp Group:</h3>
                @if ($kelas->group_link)
                    <a href="{{ $kelas->group_link }}" target="_blank"
                        class="w-full max-w-[90%] break-words text-upbg underline decoration-transparent transition hover:decoration-upbg md:max-w-none">{{ $kelas->group_link }}</a>
                @else
                    <span class="text-gray-700">-</span>
                @endif
            </div>
        </div>
        @if (auth()->user()->current_role_id == 2)
            <div class="flex h-fit flex-col gap-2 md:flex-row">
                <a href="{{ route('kelas.edit', ['slug' => $kelas->slug]) }}"
                    class="button-style button-upbg-outline text-center"><i
                        class="fa-regular fa-pen-to-square mr-1"></i>Edit</a>
                <button type="button" class="delete-kelas button-style button-red-outline"><i
                        class="fa-regular fa-trash-can mr-1"></i>Delete</button>
            </div>
        @endif
        <x-ui.modal id="delete-kelas-modal">
            <form action="{{ route('kelas.destroy', ['slug' => $kelas->slug]) }}" method="POST"
                class="flex flex-col gap-4">
                @csrf
                @method('DELETE')
                <h1 class="modal-title">Hapus Kelas</h1>
                <hr class="w-full">
                <p class="text-gray-700">Apakah anda yakin ingin menghapus kelas <span
                        class="kode-kelas font-bold">{{ $kelas->kode }}</span></p>
                <div class="danger-container flex flex-col gap-2">
                    <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
                    <p>Semua data kelas ini akan dihapus permanen</p>
                </div>
                <hr class="w-full">
                <div class="flex flex-row justify-end gap-4">
                    <button type="button"
                        class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                    <button type="submit"
                        class="submit-button button-style border-red-600 bg-red-600 text-white hover:bg-red-700">Delete</button>
                </div>
            </form>
        </x-ui.modal>
    </section>


    <section id="pertemuan-terlaksana"
        class="mt-6 flex flex-col gap-6 bg-white p-6 shadow-sm md:flex-row md:items-center md:justify-between">
        <div class="flex flex-col items-center gap-2 md:items-start">
            <p class="text-lg text-gray-700 md:text-2xl">Pertemuan Terlaksana</p>
            <p class="text-3xl font-semibold text-gray-700 md:text-4xl">{{ $kelas->progress }} /
                {{ $kelas->banyak_pertemuan }}</p>
        </div>
        <button type="button"
            class="tambah-pertemuan button-style border-green-600 bg-green-600 text-white hover:bg-green-700"><i
                class="fa-solid fa-plus mr-1"></i><span>Tambah Pertemuan</span></button>
        <x-ui.modal id="tambah-pertemuan-modal">
            <form action="{{ route('kelas.pertemuan.store', ['slug' => $kelas->slug]) }}" class="flex flex-col gap-4">
                <h1 class="text-center text-xl font-semibold capitalize text-gray-700">Tambah Pertemuan</h1>
                <hr class="w-full">
                <div class="input-group">
                    <p class="input-label">Tanggal</p>
                    <x-inputs.date inputName="tanggal" placeholder="Pilih tanggal" />
                </div>
                <div class="flex w-full flex-row items-start gap-4">
                    <div class="input-group flex-1">
                        <p class="input-label">Waktu mulai</p>
                        <x-inputs.time inputName="waktu-mulai" placeholder="Waktu mulai" />
                    </div>
                    <div class="input-group flex-1">
                        <p class="input-label">Waktu selesai</p>
                        <x-inputs.time inputName="waktu-selesai" placeholder="Waktu selesai" />
                    </div>
                </div>
                <div class="input-group">
                    <p class="input-label">Ruangan</p>
                    <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" :selected="['text' => $kelas->ruangan->kode, 'value' => $kelas->ruangan->id]">
                        @foreach ($ruanganOptions as $ruangan)
                            <x-inputs.dropdown.option :value="$ruangan->id"
                                class="{{ $ruangan->id == $kelas->ruangan->id ? 'selected' : '' }}">{{ $ruangan->kode }}</x-inputs.dropdown.option>
                        @endforeach
                    </x-inputs.dropdown.select>
                </div>
                <hr class="w-full">
                <div class="flex flex-row justify-end gap-4">
                    <button type="button"
                        class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                    <button type="submit"
                        class="submit-button button-style border-green-600 bg-green-600 text-white hover:bg-green-700">Tambah</button>
                </div>
            </form>
        </x-ui.modal>
    </section>


    <section id="daftar-pertemuan" class="pertemuan-container mt-6 flex flex-col divide-y bg-white shadow-sm">
        <div class="pertemuan-header hidden flex-row items-center py-4 lg:flex">
            <p class="min-w-28 max-w-36 flex-1 pl-4 text-center font-semibold tracking-wide text-gray-600">
                Pertemuan ke-</p>
            <p class="min-w-60 max-w-72 flex-1 px-4 text-left font-semibold tracking-wide text-gray-600">Jadwal
            </p>
            <p class="flex-1 px-4 text-left font-semibold tracking-wide text-gray-600">Pengajar</p>
            <p class="max-w-56 flex-1 px-4 text-left font-semibold tracking-wide text-gray-600">Status</p>
            <p class="w-32"></p>
        </div>
        @foreach ($kelas->pertemuan as $pertemuan)
            <div class="pertemuan-item flex flex-col gap-6 lg:flex-row lg:gap-0 lg:py-4">
                <div
                    class="order-1 flex flex-row bg-upbg-dark px-6 py-4 lg:order-none lg:min-w-28 lg:max-w-36 lg:flex-1 lg:items-center lg:justify-center lg:bg-white lg:px-0 lg:py-0 lg:pl-4">
                    <p class="text-base font-medium text-white lg:hidden">Pertemuan ke -
                        {{ $pertemuan->pertemuan_ke }}</p>
                    <p class="hidden text-2xl font-semibold text-gray-700 lg:block">{{ $pertemuan->pertemuan_ke }}
                    </p>
                </div>
                <div class="order-3 flex flex-col gap-2 px-6 lg:order-none lg:min-w-60 lg:max-w-72 lg:flex-1 lg:px-4">
                    <h3 class="font-semibold text-gray-700 lg:hidden">Jadwal:</h3>
                    <span class="text-gray-700"><i
                            class="fa-solid fa-calendar-days mr-2"></i>{{ $pertemuan->tanggal->isoFormat('dddd, D MMMM YYYY') }}</span>
                    <span class="text-gray-700"><i
                            class="fa-regular fa-clock mr-2"></i>{{ $pertemuan->waktu_mulai->isoFormat('HH:mm') . ' - ' . $pertemuan->waktu_selesai->isoFormat('HH:mm') }}</span>
                    <span class="text-gray-700"><i
                            class="fa-regular fa-building mr-2"></i>{{ $pertemuan->ruangan->kode }}</span>
                </div>
                <div class="order-4 flex flex-col gap-2 px-6 lg:order-none lg:flex-1 lg:justify-center lg:px-4">
                    <h3 class="font-semibold text-gray-700 lg:hidden">Pengajar:</h3>
                    <span
                        class="text-gray-700">{{ $pertemuan->pengajar_id ? $pertemuan->pengajar->nama : '-' }}</span>
                </div>
                <div
                    class="order-2 flex flex-col gap-2 px-6 lg:order-none lg:max-w-56 lg:flex-1 lg:justify-center lg:px-4">
                    <h3 class="font-semibold text-gray-700 lg:hidden">Status:</h3>
                    @if ($pertemuan->terlaksana)
                        <span class="font-semibold text-green-600">Terlaksana</span>
                    @else
                        @if (now()->isAfter($pertemuan->waktu_selesai))
                            <span class="font-semibold text-red-600">Tidak Terlaksana</span>
                        @else
                            <span class="text-gray-700">-</span>
                        @endif
                    @endif
                </div>
                <div
                    class="order-5 flex flex-row px-6 pb-6 lg:order-none lg:w-32 lg:items-center lg:px-0 lg:pb-0 lg:pr-6">
                    <a href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}"
                        class="button-style flex w-full flex-row items-center justify-center border-upbg text-center text-upbg hover:bg-upbg hover:text-white">View<i
                            class="fa-solid fa-circle-arrow-right ml-1"></i></a>
                </div>
            </div>
        @endforeach
    </section>

    <!-- @pushOnce('script')
    <script src="{{ asset('js/utils/form-control.js') }}"></script>
                                        <script src="{{ asset('js/views/kelas/detail-daftar-pertemuan.js') }}"></script>
@endPushOnce -->
</x-layouts.user-layout>
