<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</x-slot>
    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-3xl">Detail Pertemuan</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <section id="detail-pertemuan" class="flex flex-col gap-6 bg-white shadow-sm mt-6 p-6 md:flex-row md:justify-between">
        <div class="flex flex-col gap-6">
            <h2 class="text-gray-700 font-semibold text-xl">Pertemuan ke - {{ $pertemuan->pertemuan_ke }}</h2>
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
                <div class="flex flex-col gap-3 text-gray-700">
                    <div class="flex flex-row gap-2">
                        <i class="fa-solid fa-calendar-days w-4"></i>
                        <span class="leading-none">{{ $pertemuan->tanggal->isoFormat('dddd, D MMMM YYYY')}}</span>
                    </div>
                    <div class="flex flex-row gap-2">
                        <i class="fa-regular fa-clock w-4"></i>
                        <span class="leading-none">{{ $pertemuan->waktu_mulai->isoFormat("HH:mm") . " - " . $pertemuan->waktu_selesai->isoFormat("HH:mm") }}</span>
                    </div>
                    <div class="flex flex-row gap-2">
                        <i class="fa-regular fa-building w-4"></i>
                        <span class="leading-none">{{ $pertemuan->ruangan->kode }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-2 md:flex-row h-fit">
            <a href="{{ route('kelas.pertemuan.edit', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="button-style text-center border-upbg text-upbg hover:bg-upbg hover:text-white"><i class="fa-regular fa-pen-to-square mr-1"></i>Edit</a>
            <button type="button" class="delete-pertemuan button-style border-red-600 text-red-600 hover:bg-red-600 hover:text-white"><i class="fa-regular fa-trash-can mr-1"></i>Delete</button>
        </div>
        <x-ui.delete-dialog :action="route('kelas.pertemuan.destroy', ['slug' => $kelas->slug, 'id' => $pertemuan->id])" class="delete-pertemuan-dialog">
            <x-slot:title>Hapus Pertemuan</x-slot>
            <x-slot:message>Apakah anda yakin ingin menghapus <span class="font-bold">Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</span> dari kelas <span class="font-bold">{{ $kelas->kode }}</span> ?</x-slot>
            <x-slot:deleteMessage>
                <p class="text-red-600">Data pertemuan dan presensi dari pertemuan ini akan dihapus permanen!</p>
            </x-slot>
            <x-slot:hiddenInputs>
                <input type="hidden" name="kelas-slug" value="{{ $kelas->slug }}">
                <input type="hidden" name="pertemuan-id" value="{{ $pertemuan->id }}">
            </x-slot>
        </x-ui.delete-dialog>
    </section>

    <section id="topik-catatan" class="flex flex-col gap-4 shadow-sm mt-6 p-6 bg-white @if ($pertemuan->presensi->isEmpty() && auth()->user()->current_role_id == 2) mb-20 @endif" data-slug="{{ $kelas->slug }}" data-id="{{ $pertemuan->id }}">
        <div class="topik flex flex-col gap-2 input-group">
            <h3 class="font-semibold text-gray-700">Topik Bahasan</h3>
            <p class="text-gray-600">{!! ($pertemuan->topik) ? $pertemuan->topik : '-' !!}</p>
        </div>
        <div class="catatan flex flex-col gap-2 input-group">
            <h3 class="font-semibold text-gray-700">Catatan</h3>
            <p class="text-gray-600">{!! ($pertemuan->catatan) ? $pertemuan->catatan : '-' !!}</p>
        </div>
        <button class="edit-topik-catatan button-style text-upbg border-upbg text-center hover:text-white hover:bg-upbg">
            <i class="fa-regular fa-pen-to-square mr-1"></i>
            Edit
        </button>
    </section>
    
    @if ($pertemuan->presensi->isEmpty())
        @if (auth()->user()->current_role_id == 3)
            <hr class="bg-gray-200 my-10">
            @if (now()->isBefore($pertemuan->waktu_selesai))
                <div class="flex flex-col items-center shadow-strong p-8 gap-6 mb-20">
                    <p class="text-gray-600">Mulai pertemuan untuk membuat daftar kehadiran</p>
                    <button @if(now()->isBefore($pertemuan->waktuMulai)) disabled @endif type="button" class="mulai-pertemuan px-6 py-2 rounded-md bg-upbg text-white font-medium transition duration-300 hover:bg-upbg-dark disabled:opacity-70 disabled:hover:bg-upbg">Mulai Pertemuan</button>
                    
                    <x-ui.modal id="mulai-pertemuan-modal">
                        <h1 class="text-center text-gray-800 text-2xl font-bold">Mulai Pertemuan</h1>
                        <form action="{{ route('kelas.pertemuan.mulaiPertemuan', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="w-112 flex flex-col gap-4">
                            <input type="hidden" name="terlaksana" value="1">
                            <x-inputs.dropdown :selected="$pengajarSelected" :options="$pengajarOptions" inputName="pengajar-id" label="Pilih pengajar"/>
                            <div class="flex flex-row justify-end gap-4 mt-6">
                                <button type="button" class="cancel-button px-8 py-2 text-gray-600 bg-white transition duration-300 hover:bg-gray-100 font-semibold rounded-sm-md">Cancel</button>
                                <button type="submit" class="submit-button px-8 py-2 bg-upbg transition duration-300 hover:bg-upbg-dark text-white font-semibold rounded-sm-md">Mulai</button>
                            </div>
                        </form>
                    </x-ui.modal>
                    
                    @if(now()->isBefore($pertemuan->waktuMulai))
                        <p class="countdown-label text-gray-600 text-center">Pertemuan dapat dimulai dalam,<br><span data-waktu-mulai="{{ $pertemuan->waktu_mulai }}" class="countdown text-upbg font-semibold">0d 0h 0m 0s</span></p>
                    @endif
                </div>
            @else
                <div class="flex flex-col items-center shadow-strong p-8 gap-6 mb-20">
                    <p class="text-red-600 font-semibold">Pertemuan telah selesai</p>
                    <p class="text-gray-600">Silahkan reschedule pertemuan atau tambahkan catatan alasan pertemuan tidak terlaksana untuk admin</p>
                </div>
            @endif
        @endif
    @else
        <section id="daftar-presensi" class="flex flex-col shadow-sm mt-6 mb-20">
            <div class="flex flex-col bg-white p-6 gap-6 md:flex-row md:justify-between">
                <div class="flex flex-col items-center gap-2 md:items-start">
                    <p class="text-lg text-gray-700 md:text-2xl">Kehadiran Peserta</p>
                    <p class="hadir-count text-3xl text-gray-700 font-semibold md:text-4xl">@if ($pertemuan->presensi->isEmpty()) 0 / 0 @else {{ $pertemuan->hadirCount }} / {{ $pertemuan->presensi->count() }} @endif</p>
                </div>
                <div class="flex flex-col gap-2 justify-center">
                    <button type="button" class="tambah-presensi button-style border-green-600 bg-green-600 hover:bg-green-700 text-white"><i class="fa-solid fa-plus mr-1"></i><span>Tambah Presensi</span></button>
                    <form action="{{ route('presensi.updatePresensiAll', ['pertemuanId' => $pertemuan->id]) }}" class="tandai-semua-hadir w-full">
                        <button type="submit" class="button-style w-full border-green-600 text-green-600 hover:text-white hover:bg-green-600"><i class="fa-regular fa-square-check mr-1"></i>Tandai Semua Hadir</button>
                    </form>
                    <x-ui.modal id="tambah-presensi-modal">
                        <h1 class="text-xl font-semibold text-gray-700 text-center capitalize">Tambah Presensi</h1>
                        @if ($tambahPesertaOptions->isEmpty())
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col justify-start p-4 bg-green-100 rounded-md text-sm">
                                    <p class="text-green-600 font-semibold mb-2"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
                                    <p class="text-green-600">Semua peserta sudah ditambahkan ke pertemuan ini</p>
                                </div>
                                <button type="button" class="cancel-button button-style border-none text-gray-700 hover:bg-gray-100">Cancel</button>
                            </div>
                        @else
                            <hr class="bg-gray-200">
                            <form action="{{ route('presensi.store') }}" class="flex flex-col gap-4">
                                <input type="hidden" name="pertemuan-id" value="{{ $pertemuan->id }}">
                                <x-inputs.dropdown :selected="$tambahPesertaSelected" :options="$tambahPesertaOptions" placeholder="Pilih peserta" inputName="peserta-id" label="Pilih peserta"/>
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
                    </x-ui.modal>
                </div>
            </div>
            
            <div class="presensi-container flex flex-col border-t divide-y bg-white">
                <div class="presensi-header py-2 flex flex-row items-center sm:py-4">
                    <p class="w-12 text-gray-600 font-semibold tracking-wide text-center sm:w-20 sm:px-6">No.</p>
                    <p class="flex-1 px-2 text-gray-600 font-semibold tracking-wide text-left">Peserta</p>
                    <p class="w-24 text-gray-600 font-semibold tracking-wide text-left sm:w-48 sm:px-6">Status Kehadiran</p>
                    <p class="md:block md:w-24 md:mx-6"></p>
                </div>
                @foreach ($pertemuan->presensi as $presensi)
                    <div class="presensi-item flex flex-col md:flex-row" data-presensi-id="{{ $presensi->id }}">
                        <div class="presensi-content flex flex-row items-center py-5 sm:cursor-pointer md:flex-1">
                            <p class="w-12 text-center font-medium sm:w-20 sm:px-6">{{ $loop->iteration }}.</p>
                            <div class="flex-1 px-2 flex flex-col">
                                <p class="nama-peserta w-fit font-medium text-gray-700">{{ $presensi->peserta->nama }}</p>
                                <p class="nik-peserta w-fit text-gray-600">{{ $presensi->peserta->nik }}</p>
                            </div>
                            <form action="{{ route('presensi.updatePresensi', ['id' => $presensi->id]) }}" class="form-toggle-kehadiran flex flex-row gap-2 w-24 sm:w-48 sm:px-6">
                                @if ($presensi->hadir)
                                    <button type="submit" name="hadir" value="1" class="button-hadir active">H</button>
                                    <button type="submit" name="hadir" value="0" class="button-alfa border">A</button>
                                @else
                                    <button type="submit" name="hadir" value="1" class="button-hadir">H</button>
                                    <button type="submit" name="hadir" value="0" class="button-alfa active">A</button>
                                @endif
                            </form>
                        </div>
                        <div class="delete-presensi-container flex-row justify-center items-center py-4 bg-gray-50 border-t md:flex md:w-24 md:mx-6 md:bg-white md:border-none">
                            <button type="button" class="delete-presensi button-style text-red-600 border-red-600 bg-white hover:bg-red-600 hover:text-white">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <x-ui.delete-dialog :action="route('presensi.destroy')" class="delete-presensi-dialog">
                <x-slot:title>Hapus Presensi</x-slot>
                <x-slot:message>Apakah anda yakin ingin menghapus <span class="font-bold nama-nik-user">User</span> dari daftar kehadiran?</x-slot>
                <x-slot:deleteMessage>
                    <p class="text-red-600">Anda dapat menambahkan kembali peserta menggunakan opsi "Tambah Presensi"</p>
                </x-slot>
                <x-slot:hiddenInputs>
                    <input type="hidden" name="id" value="">
                </x-slot>
            </x-ui.delete-dialog>
        </section>
    @endif

    @push('script')
        <script src="{{ asset('js/utils/countdown.js') }}"></script>
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/pertemuan/detail-pertemuan.js') }}"></script>
    @endpush
</x-layouts.user-layout>