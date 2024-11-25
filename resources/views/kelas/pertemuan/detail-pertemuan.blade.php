<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

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
                    @if (auth()->user()->current_role_id == 2)
                        <a href="{{ route('kelas.pertemuan.edit', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="bg-white text-sm border px-4 py-2 rounded-md text-gray-800 overflow-hidden group text-center hover:text-upbg">
                            <span class="inline-block font-medium translate-x-3 transition duration-300 group-hover:translate-x-0 leading-none">Edit</span>
                            <i class="fa-regular fa-pen-to-square ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
                        </a>
                    @elseif (auth()->user()->current_role_id == 3)
                        @if (!$pertemuan->terlaksana)
                            <button type="button" class="reschedule-pertemuan bg-white text-sm border px-4 py-2 rounded-md text-gray-800 overflow-hidden group text-center hover:text-upbg">
                                <span class="inline-block font-medium translate-x-3 transition duration-300 group-hover:translate-x-0 leading-none">Reschedule</span>
                                <i class="fa-regular fa-calendar-check ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
                            </button>
                            <x-ui.modal id="reschedule-pertemuan-modal">
                                <h1 class="text-center text-gray-800 text-2xl font-bold">Reschedule Pertemuan</h1>
                                <form action="{{ route('kelas.pertemuan.reschedule', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" class="w-112 flex flex-col gap-4">
                                    <x-inputs.date inputName="tanggal" label="Tanggal" placeholder="Pilih tanggal" value="{{ $pertemuan->tanggal }}"/>
                                    <div class="flex flex-row items-start gap-4">
                                        <x-inputs.time inputName="waktu-mulai" label="Waktu mulai" placeholder="Pilih waktu mulai" :value="$pertemuan->waktu_mulai"/>
                                        <x-inputs.time inputName="waktu-selesai" label="Waktu selesai" placeholder="Pilih waktu selesai" :value="$pertemuan->waktu_selesai"/>
                                    </div>
                                    <x-inputs.dropdown :selected="$ruanganSelected" :options="$ruanganOptions" inputName="ruangan-kode" label="Pilih ruangan" placeholder="Pilih ruangan"/>
                                    <div class="flex flex-row justify-end gap-4 mt-6">
                                        <button type="button" class="cancel-button px-8 py-2 text-gray-600 bg-white transition duration-300 hover:bg-gray-100 font-medium rounded-sm-md">Cancel</button>
                                        <button type="submit" class="submit-button px-8 py-2 bg-upbg transition duration-300 hover:bg-upbg-dark text-white font-medium rounded-sm-md">Simpan</button>
                                    </div>
                                </form>
                            </x-ui.modal>
                        @endif
                    @endif
                    <button type="button" class="delete-pertemuan block group overflow-hidden w-full text-red-600 text-sm border rounded-md px-4 py-2 bg-white">
                        <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover:translate-x-0">Delete</span>
                        <i class="fa-regular fa-trash-can ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0""></i>
                    </button>
                    <x-ui.delete-dialog :action="route('kelas.pertemuan.destroy', ['slug' => $kelas->slug, 'id' => $pertemuan->id])" class="delete-pertemuan-dialog">
                        <x-slot:title>Hapus pertemuan?</x-slot>
                        <x-slot:message>Apakah anda yakin ingin menghapus <span class="font-bold">Pertemuan Ke - {{ $pertemuan->pertemuan_ke }}</span> dari kelas <span class="font-bold">{{ $kelas->kode }}</span> ?</x-slot>
                        <x-slot:deleteMessage>
                            <p class="text-red-600">Data pertemuan dan presensi dari pertemuan ini akan dihapus permanen!</p>
                        </x-slot>
                        <x-slot:hiddenInputs>
                            <input type="hidden" name="kelas-slug" value="{{ $kelas->slug }}">
                            <input type="hidden" name="pertemuan-id" value="{{ $pertemuan->id }}">
                        </x-slot>
                    </x-ui.delete-dialog>
                </div>
                <div class="flex flex-col gap-3 items-end">
                    <p class="text-2xl text-gray-800">Kehadiran Peserta</p>
                    <p class="text-5xl font-semibold hadir-count">@if ($pertemuan->presensi->isEmpty()) 0 / 0 @else {{ $pertemuan->hadirCount }} / {{ $pertemuan->presensi->count() }} @endif</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="bg-gray-200 my-10">

    <div id="topik-catatan" class="flex flex-col gap-4 shadow-strong mt-6 p-8 relative @if ($pertemuan->presensi->isEmpty() && auth()->user()->current_role_id == 2) mb-20 @endif" data-slug="{{ $kelas->slug }}" data-id="{{ $pertemuan->id }}">
        <div class="topik flex flex-col gap-2 input-group">
            <h3 class="font-semibold text-sm text-gray-800">Topik Bahasan</h3>
            <p class="text-gray-600 text-base">{!! ($pertemuan->topik) ? $pertemuan->topik : '-' !!}</p>
        </div>
        <div class="catatan flex flex-col gap-2 input-group">
            <h3 class="font-semibold text-sm text-gray-800">Catatan</h3>
            <p class="text-gray-600 text-base">{!! ($pertemuan->catatan) ? $pertemuan->catatan : '-' !!}</p>
        </div>
        <button class="absolute top-8 right-8 edit-topik-catatan block group overflow-hidden text-gray-800 text-center text-sm border rounded-md px-6 py-2 bg-white h-fit hover:text-upbg">
            <span class="inline-block font-medium translate-x-3 transition duration-300 group-hover:translate-x-0 leading-none">Edit</span>
            <i class="fa-regular fa-pen-to-square ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
        </button>
    </div>
    
    @if ($pertemuan->presensi->isEmpty())
        @if (auth()->user()->current_role_id == 3)
            <hr class="bg-gray-200 my-10">
            <div class="flex flex-col items-center shadow-strong p-8 gap-6 mb-20">
                <p class="text-gray-600">Mulai pertemuan untuk membuat daftar kehadiran</p>
                <button id="mulai-pertemuan" @if(now()->isBefore($pertemuan->waktuMulai)) disabled @endif type="button" class="border px-6 py-2 rounded-md bg-upbg text-white font-medium transition duration-300 hover:bg-upbg-dark disabled:opacity-70 disabled:hover:bg-upbg">Mulai Pertemuan</button>
                
                <x-ui.modal id="mulai-pertemuan-modal">
                    <form action="{{ route('kelas.pertemuan.updateStatus', ['slug' => $kelas->slug, 'id' => $pertemuan->id]) }}" method="POST" class="w-112 flex flex-col gap-4">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="terlaksana" value="1">
                        <x-inputs.dropdown :selected="$pengajarSelected" :options="$pengajarOptions" inputName="pengajar-id" label="Pilih pengajar"/>
                        <div class="flex flex-col">
                            <label class="block font-medium text-sm mb-1.5 text-gray-600">Topik Bahasan (opsional)</label>
                            <textarea id="topik-bahasan" name="topik-bahasan" placeholder="Topik bahasan" class="border resize-none p-2 rounded-md w-full h-48 bg-gray-100 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light"></textarea>
                        </div>
                        <div class="flex flex-row justify-center gap-4 mt-6">
                            <button type="button" class="cancel-button px-8 py-2 text-gray-600 bg-white transition duration-300 hover:bg-gray-100 font-semibold rounded-sm-md">Cancel</button>
                            <button type="submit" class="submit-button px-8 py-2 bg-upbg transition duration-300 hover:bg-upbg-dark text-white font-semibold rounded-sm-md">Mulai</button>
                        </div>
                    </form>
                </x-ui.modal>
                
                @if(now()->isBefore($pertemuan->waktuMulai))
                    <p class="countdown-label text-gray-600 text-center">Pertemuan dapat dimulai dalam,<br><span data-waktu-mulai="{{ $pertemuan->waktu_mulai }}" class="countdown text-upbg font-semibold">0d 0h 0m 0s</span></p>
                @endif
            </div>
        @endif
    @else
        <hr class="bg-gray-200 my-10">
        <div id="daftar-presensi" class="flex flex-col mb-20">
            <div class="flex flex-row justify-end gap-4">
                <form action="{{ route('presensi.updatePresensiAll', ['pertemuanId' => $pertemuan->id]) }}" class="tandai-semua-hadir">
                    <button type="submit" class="group overflow-hidden text-green-600 text-sm border border-green-600 rounded-md px-4 py-2 bg-white">
                        <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover:translate-x-0">Tandai Semua Hadir</span>
                        <i class="fa-regular fa-square-check ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0"></i>
                    </button>
                </form>
                <button id="tambah-presensi" type="button" class="bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-sm px-4 py-2 font-medium text-white rounded-md">
                    <i class="fa-solid fa-plus mr-1"></i>
                    <span>Tambah Presensi</span>
                </button>
                <x-ui.modal id="tambah-presensi-modal">
                    <h1 class="text-center text-gray-800 text-2xl font-bold">Tambah Presensi</h1>
                    @if ($tambahPesertaOptions->isEmpty())
                        <div class="w-96 flex flex-col gap-4">
                            <div class="flex flex-col justify-start p-4 bg-green-100 rounded-md text-sm">
                                <p class="text-green-600 font-semibold mb-2"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
                                <p class="text-green-600">Semua peserta sudah ditambahkan ke pertemuan ini</p>
                            </div>
                            <button type="button" class="cancel-button px-8 py-2 text-gray-600 bg-white transition duration-300 hover:bg-gray-100 font-medium rounded-sm-md">Cancel</button>
                        </div>
                    @else
                        <form action="{{ route('presensi.store') }}" class="w-96 flex flex-col gap-4">
                            <input type="hidden" name="pertemuan-id" value="{{ $pertemuan->id }}">
                            <x-inputs.dropdown :selected="$tambahPesertaSelected" :options="$tambahPesertaOptions" placeholder="Pilih peserta" inputName="peserta-id" label="Pilih peserta"/>
                            <div class="flex flex-col justify-start p-4 bg-green-100 rounded-md text-sm">
                                <p class="text-green-600 font-semibold mb-2"><i class="fa-solid fa-circle-info mr-2"></i>Info</p>
                                <p class="text-green-600">Jika peserta tidak ada dalam daftar, pastikan peserta sudah terdaftar di kelas ini</p>
                            </div>
                            <div class="flex flex-row justify-end gap-4 mt-6">
                                <button type="button" class="cancel-button px-8 py-2 text-gray-600 bg-white transition duration-300 hover:bg-gray-100 font-medium rounded-sm-md">Cancel</button>
                                <button type="submit" class="submit-button px-8 py-2 bg-green-600 transition duration-300 hover:bg-green-700 text-white font-medium rounded-sm-md">Tambah</button>
                            </div>
                        </form>
                    @endif
                </x-ui.modal>
            </div>
            <table class="w-full table-fixed hidden lg:table shadow-strong mt-6">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="w-20 px-6 py-4 text-gray-600 font-semibold tracking-wide text-center">No.</th>
                        <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Peserta</th>
                        <th class="px-6 py-4 text-gray-600 font-semibold tracking-wide text-left">Status Kehadiran</th>
                        <th class="w-40 px-6 py-4 text-gray-600 font-semibold tracking-wide text-center"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($pertemuan->presensi as $presensi)
                        <tr class="bg-white transition hover:bg-gray-100" data-presensi-id="{{ $presensi->id }}">
                            <td class="px-6 py-6 text-center">
                                <span class="text-gray-800 font-medium text-lg">{{ $loop->iteration }}.</span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <a href="#" class="nama-peserta font-medium underline decoration-transparent text-gray-800 transition hover:text-upbg hover:decoration-upbg">{{ $presensi->peserta->nama }}</a>
                                    <p class="nik-peserta text-sm text-gray-600">{{ $presensi->peserta->nik }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <form action="{{ route('presensi.updatePresensi', ['id' => $presensi->id]) }}" class="form-toggle-kehadiran flex flex-row gap-2">
                                    @if ($presensi->hadir)
                                        <button type="submit" value="1" class="button-hadir border rounded-full size-10 active">H</button>
                                        <button type="submit" value="0" class="button-alfa border rounded-full size-10 bg-white">A</button>
                                    @else
                                        <button type="submit" value="1" class="button-hadir border rounded-full size-10 bg-white">H</button>
                                        <button type="submit" value="0" class="button-alfa border rounded-full size-10 active">A</button>
                                    @endif
                                </form>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <button type="button" class="delete-presensi block group overflow-hidden w-full text-red-600 text-sm border rounded-md px-3 py-2 bg-white hover:shadow-md">
                                    <span class="inline-block font-medium translate-x-2.5 transition duration-300 group-hover:translate-x-0">Remove</span>
                                    <i class="fa-regular fa-trash-can ml-1 inline-block transition duration-300 translate-x-12 group-hover:translate-x-0""></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <x-ui.delete-dialog :action="route('presensi.destroy')" class="delete-presensi-dialog">
                <x-slot:title>Hapus presensi?</x-slot>
                <x-slot:message>Apakah anda yakin ingin menghapus <span class="font-bold nama-nik-user">User</span> dari daftar kehadiran</x-slot>
                <x-slot:deleteMessage>
                    <p class="text-red-600">Anda dapat menambahkan kembali peserta menggunakan opsi "Tambah Presensi"</p>
                </x-slot>
                <x-slot:hiddenInputs>
                    <input type="hidden" name="id" value="">
                </x-slot>
            </x-ui.delete-dialog>
        </div>
    @endif

    @push('script')
        <script src="{{ asset('js/utils/countdown.js') }}"></script>
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/kelas/pertemuan/detail-pertemuan.js') }}"></script>
    @endpush
</x-layouts.user-layout>