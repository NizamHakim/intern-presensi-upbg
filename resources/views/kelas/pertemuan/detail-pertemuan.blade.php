<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</x-slot>
    <x-slot:sidenav>
        <x-layouts.navgroup title="Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}">
            <x-layouts.navlink href="{{ route('kelas.pertemuan.detail', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" routeName="kelas.pertemuan.detail">Detail Pertemuan</x-layouts.navlink>
        </x-layouts.navgroup>
        <x-layouts.navgroup title="{{ $kelas->kode }}">
            <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
            <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
        </x-layouts.navgroup>
        <hr>
    </x-slot>

    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="page-title">Detail Pertemuan</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <section id="detail-pertemuan" class="flex flex-col gap-6 bg-white shadow-sm mt-6 p-6 md:flex-row md:justify-between">
        <div class="flex flex-col gap-6">
            <h2 class="text-gray-700 font-semibold text-xl md:text-2xl">Pertemuan ke - {{ $pertemuan->pertemuan_ke }}</h2>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-1">Status:</h3>
                @if ($pertemuan->terlaksana)
                    <span class="text-green-600 font-semibold">Terlaksana</span>
                @else
                    @if (now()->isAfter($pertemuan->waktu_selesai))
                        <span class="text-red-600 font-semibold">Tidak Terlaksana</span>
                    @else
                        <span class="text-gray-600 font-semibold">-</span>
                    @endif
                @endif
            </div>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-1">Pengajar:</h3>
                @if ($pertemuan->pengajar_id)
                    <a href="{{ route('user.detail', ['id' => $pertemuan->pengajar->id]) }}" class="underline decoration-transparent text-gray-700 transition hover:text-upbg hover:decoration-upbg">{{ $pertemuan->pengajar->nama }}</a>
                @else
                    <span class="text-gray-700 font-semibold">-</span>
                @endif
            </div>
            <div class="flex flex-col">
                <h3 class="font-semibold text-gray-700 mb-2">Jadwal:</h3>
                <div class="flex flex-col gap-2 text-gray-700">
                    <span><i class="fa-solid fa-calendar-days mr-2"></i>{{ $pertemuan->tanggal->isoFormat('dddd, D MMMM YYYY')}}</span>
                    <span><i class="fa-regular fa-clock mr-2"></i>{{ $pertemuan->waktu_mulai->isoFormat("HH:mm") . " - " . $pertemuan->waktu_selesai->isoFormat("HH:mm") }}</span>
                    <span><i class="fa-regular fa-building mr-2"></i>{{ $pertemuan->ruangan->kode }}</span>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-2 h-fit md:flex-row">
            @if (auth()->user()->current_role_id == 2)
                <a href="{{ route('kelas.pertemuan.edit', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="edit-pertemuan button-style button-upbg-outline text-center"><i class="fa-regular fa-pen-to-square mr-1"></i>Edit</a>
            @elseif (auth()->user()->current_role_id == 3 && $pertemuan->presensi->isEmpty())
                <button type="button" class="reschedule-pertemuan button-style button-upbg-outline"><i class="fa-regular fa-calendar-check mr-1"></i>Reschedule</button>
                <x-ui.modal id="reschedule-pertemuan-modal">
                    <form action="{{ route('kelas.pertemuan.reschedule', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="flex flex-col gap-4">
                        <h1 class="text-xl font-semibold text-gray-700 text-center capitalize">Reschedule Pertemuan</h1>
                        <hr class="w-full">
                        <div class="input-group">
                            <p class="input-label">Tanggal</p>
                            <x-inputs.date inputName="tanggal" :value="$pertemuan->tanggal" placeholder="Pilih tanggal"/>
                        </div>
                        <div class="w-full flex flex-row items-start gap-4">
                            <div class="input-group flex-1">
                                <p class="input-label">Waktu mulai</p>
                                <x-inputs.time inputName="waktu-mulai" :value="$pertemuan->waktu_mulai" placeholder="Waktu mulai"/>
                            </div>
                            <div class="input-group flex-1">
                                <p class="input-label">Waktu selesai</p>
                                <x-inputs.time inputName="waktu-selesai" :value="$pertemuan->waktu_selesai" placeholder="Waktu selesai"/>
                            </div>
                        </div>
                        <div class="input-group">
                            <p class="input-label">Ruangan</p>
                            <x-inputs.dropdown.select name="ruangan" placeholder="Pilih ruangan" :selected="['text' => $pertemuan->ruangan->kode, 'value' => $pertemuan->ruangan->id]">
                                @foreach ($ruanganOptions as $ruangan)
                                    <x-inputs.dropdown.option :value="$ruangan->id" class="{{ ($ruangan->id == $pertemuan->ruangan->id) ? 'selected' : '' }}">{{ $ruangan->kode }}</x-inputs.dropdown.option>
                                @endforeach
                            </x-inputs.dropdown.select>
                        </div>
                        <hr class="w-full">
                        <div class="flex flex-row justify-end gap-4">
                            <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                            <button type="submit" class="submit-button button-style button-upbg-solid">Tambah</button>
                        </div>
                    </form>
                </x-ui.modal>
            @endif
            <button type="button" class="delete-pertemuan button-style button-red-outline"><i class="fa-regular fa-trash-can mr-1"></i>Delete</button>
        </div>
        <x-ui.modal id="delete-pertemuan-modal">
            <form action="{{ route('kelas.pertemuan.destroy', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('DELETE')
                <h1 class="modal-title">Hapus Pertemuan</h1>
                <hr class="w-full">
                <p class="text-gray-700">Apakah anda yakin ingin menghapus <span class="font-semibold">Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</span> dari kelas <span class="font-semibold">{{ $kelas->kode }}</span></p>
                <div class="danger-container flex flex-col gap-2">
                    <p class="font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Peringatan</p>
                    <p>Semua data pertemuan ini akan dihapus permanen</p>
                </div>
                <hr class="w-full">
                <div class="flex flex-row justify-end gap-4">
                    <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                    <button type="submit" class="submit-button button-style border-red-600 bg-red-600 text-white hover:bg-red-700">Delete</button>
                </div>
            </form>
        </x-ui.modal>
    </section>

    <section id="topik-catatan" class="flex flex-col gap-4 shadow-sm mt-6 p-6 bg-white" data-slug="{{ $kelas->slug }}" data-id="{{ $pertemuan->id }}">
        <div class="topik flex flex-col gap-2 input-group">
            <h3 class="font-semibold text-gray-700">Topik Bahasan</h3>
            <p class="text-gray-600 break-words text-wrap">{!! ($pertemuan->topik) ? $pertemuan->topik : '-' !!}</p>
        </div>
        <div class="catatan flex flex-col gap-2 input-group">
            <h3 class="font-semibold text-gray-700">Catatan</h3>
            <p class="text-gray-600 break-words text-wrap">{!! ($pertemuan->catatan) ? $pertemuan->catatan : '-' !!}</p>
        </div>
        <button class="edit-topik-catatan button-style button-upbg-outline"><i class="fa-regular fa-pen-to-square mr-1"></i>Edit</button>
    </section>

    @if ($pertemuan->presensi->isEmpty())
        @if (auth()->user()->current_role_id == 3)
            <section id="notice-presensi" class="flex flex-col items-center gap-4 shadow-sm mt-6 p-6 bg-white">    
                @if (now()->isBefore($pertemuan->waktu_selesai))
                    <p class="text-gray-600 text-center">Mulai pertemuan untuk membuat daftar kehadiran</p>
                    
                    <button @if(now()->isBefore($pertemuan->waktuMulai)) disabled @endif type="button" class="mulai-pertemuan button-style button-upbg-solid disabled:opacity-70 disabled:hover:bg-upbg">Mulai Pertemuan</button>
                    @if(now()->isBefore($pertemuan->waktuMulai))
                        <p class="countdown-label text-gray-600 text-center">Pertemuan dapat dimulai dalam,<br><span data-waktu-mulai="{{ $pertemuan->waktu_mulai }}" class="countdown text-upbg font-semibold">0d 0h 0m 0s</span></p>
                    @endif
                    
                    <x-ui.modal id="mulai-pertemuan-modal">
                        <form action="{{ route('kelas.pertemuan.mulaiPertemuan', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="flex flex-col gap-4">
                            <h1 class="modal-title">Mulai Pertemuan</h1>
                            <hr class="w-full">
                            <input type="hidden" name="terlaksana" value="1">
                            <div class="input-group">
                                <p class="input-label">Pilih pengajar</p>
                                <x-inputs.dropdown.select name="pengajar-id" placeholder="Pilih pengajar" class="pengajar-dropdown">
                                    @foreach ($pengajarOptions as $pengajar)
                                        <x-inputs.dropdown.option :value="$pengajar->id">{{ $pengajar->nama }}</x-inputs.dropdown.option>
                                    @endforeach
                                </x-inputs.dropdown.select>
                            </div>
                            <hr class="w-full">
                            <div class="flex flex-row justify-end gap-4 mt-6">
                                <button type="button" class="cancel-button button-style border-none bg-white hover:bg-gray-100">Cancel</button>
                                <button type="submit" class="submit-button button-style button-upbg-solid">Mulai</button>
                            </div>
                        </form>
                    </x-ui.modal>
                @else
                    <p class="text-red-600 font-semibold text-base">Pertemuan telah selesai</p>
                    <p class="text-gray-600 text-center">Silahkan <span class="font-semibold">Reschedule</span> pertemuan atau tambahkan <span class="font-semibold">Catatan</span> alasan pertemuan tidak terlaksana untuk admin</p>
                @endif
            </section>
        @endif
    @else
        <section id="daftar-presensi" class="flex flex-col shadow-sm mt-6">
            <div class="flex flex-col bg-white p-6 gap-6 md:flex-row md:justify-between">
                <div class="flex flex-col items-center gap-2 md:items-start">
                    <p class="text-lg text-gray-700 md:text-2xl">Kehadiran Peserta</p>
                    <p class="hadir-count text-3xl text-gray-700 font-semibold md:text-4xl">@if ($pertemuan->presensi->isEmpty()) 0 / 0 @else {{ $pertemuan->hadirCount }} / {{ $pertemuan->presensi->count() }} @endif</p>
                </div>
                <div class="flex flex-col gap-2 justify-center">
                    <button type="button" class="tambah-presensi button-style button-green-solid"><i class="fa-solid fa-plus mr-1"></i><span>Tambah Presensi</span></button>
                    <form action="{{ route('presensi.updatePresensiAll', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="tandai-semua-hadir w-full flex flex-col min-w-[195px]">
                        <button type="submit" class="button-style button-green-outline"><i class="fa-regular fa-square-check mr-1"></i>Tandai Semua Hadir</button>
                    </form>
                    <x-ui.modal id="tambah-presensi-modal">
                        <div class="flex flex-col gap-4">
                            <h1 class="modal-title">Tambah Presensi</h1>
                            @if ($tambahPesertaOptions->isEmpty())
                                <div class="flex flex-col gap-4">
                                    <div class="flex flex-col justify-start p-4 bg-green-100 rounded-md text-sm">
                                        <p class="text-green-600 font-semibold mb-2"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
                                        <p class="text-green-600">Semua peserta sudah ditambahkan ke pertemuan ini</p>
                                    </div>
                                    <button type="button" class="cancel-button button-style border-none text-gray-700 hover:bg-gray-100">Cancel</button>
                                </div>
                            @else
                                <hr class="w-full">
                                <form action="{{ route('presensi.store', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="flex flex-col gap-4">
                                    <div class="input-group">
                                        <p class="input-label">Pilih peserta</p>
                                        <x-inputs.dropdown.select name="peserta-id" placeholder="Pilih peserta" class="peserta-dropdown">
                                            @foreach ($tambahPesertaOptions as $peserta)
                                                <x-inputs.dropdown.option :value="$peserta->id">{{ "$peserta->nama" }}</x-inputs.dropdown.option>
                                            @endforeach
                                        </x-inputs.dropdown.select>
                                    </div>
                                    <div class="input-group">
                                        <p class="input-label">Status kehadiran</p>
                                        <x-inputs.dropdown.select name="hadir" :selected="['text' => 'Hadir', 'value' => 1]" class="status-dropdown">
                                            <x-inputs.dropdown.option :value="0">Tidak Hadir</x-inputs.dropdown.option>
                                            <x-inputs.dropdown.option :value="1" class="selected">Hadir</x-inputs.dropdown.option>
                                        </x-inputs.dropdown.select>
                                    </div>
                                    <div class="flex flex-col justify-start p-4 bg-green-100 rounded-md text-sm">
                                        <p class="text-green-600 font-semibold mb-2"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
                                        <p class="text-green-600">Jika peserta tidak ada dalam daftar, pastikan peserta sudah terdaftar di kelas ini</p>
                                    </div>
                                    <hr class="bg-gray-200 w-full my-4">
                                    <div class="flex flex-row justify-end gap-4">
                                        <button type="button" class="cancel-button button-style border-none text-gray-700 hover:bg-gray-100">Cancel</button>
                                        <button type="submit" class="submit-button button-style border-green-600 bg-green-600 text-white hover:bg-green-700">Tambah</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </x-ui.modal>
                </div>
            </div>
            
            <div class="presensi-container flex flex-col border-t divide-y bg-white">
                <div class="presensi-header py-2 flex flex-row items-center sm:py-4">
                    <p class="w-12 text-gray-600 font-semibold tracking-wide text-center sm:w-20 sm:px-6">No.</p>
                    <p class="flex-1 px-2 text-gray-600 font-semibold tracking-wide text-left">Peserta</p>
                    <p class="flex-1 min-w-24 text-gray-600 font-semibold tracking-wide text-center md:text-left">Status Kehadiran</p>
                </div>
                @foreach ($pertemuan->presensi as $presensi)
                    <div class="presensi-item flex flex-row items-center py-5" data-presensi-id="{{ $presensi->id }}">
                        <p class="w-12 text-center font-medium sm:w-20 sm:px-6">{{ $loop->iteration }}.</p>
                        <div class="flex-1 px-2 flex flex-col">
                            <p class="nama-peserta w-fit font-medium text-gray-700">{{ $presensi->peserta->nama }}</p>
                            <p class="nik-peserta w-fit text-gray-600">{{ $presensi->peserta->nik }}</p>
                        </div>
                        <form action="{{ route('presensi.updatePresensi', ['slug' => $kelas->slug, 'id' => $pertemuan->id, 'presensiId' => $presensi->id]) }}" class="form-toggle-kehadiran flex-1 min-w-24 flex flex-row justify-center gap-2 md:justify-start">
                            @if ($presensi->hadir)
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
    @endif

    @push('script')
        <script src="{{ asset('js/utils/countdown.js') }}"></script>
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/pertemuan/detail-pertemuan.js') }}"></script>
    @endpush
</x-layouts.user-layout>