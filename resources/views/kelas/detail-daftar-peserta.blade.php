<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <x-slot:title>{{ $kelas->kode }}</x-slot>
    <x-slot:sidenav>
        <x-layouts.navgroup title="{{ $kelas->kode }}">
            <x-layouts.navlink href="{{ route('kelas.detail', ['slug' => $kelas->slug]) }}" routeName="kelas.detail">Detail Kelas</x-layouts.navlink>
            <x-layouts.navlink href="{{ route('kelas.daftarPeserta', ['slug' => $kelas->slug]) }}" routeName="kelas.daftarPeserta">Daftar Peserta</x-layouts.navlink>
        </x-layouts.navgroup>
        <hr>
    </x-slot>

    <div class="flex flex-col gap-6 mt-6 mb-8">
        <h1 class="font-bold text-upbg text-3xl">Daftar Peserta</h1>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <section id="daftar-peserta" class="flex flex-col">
        <div class="flex flex-row justify-end mb-4">
            <a href="{{ route('kelas.tambahPeserta', ['slug' => $kelas->slug]) }}" class="button-style border-green-600 bg-green-600 hover:bg-green-700 text-white"><i class="fa-solid fa-plus mr-1"></i>Tambah Peserta</a>
        </div>
        <div class="peserta-container flex flex-col bg-white divide-y shadow-sm">
            <div class="peserta-header py-2 flex flex-row items-center sm:py-4">
                <p class="w-12 text-gray-600 font-semibold tracking-wide text-center sm:w-20 sm:px-6">No.</p>
                <p class="flex-1 px-2 text-gray-600 font-semibold tracking-wide text-left">Peserta</p>
                <p class="w-24 text-gray-600 font-semibold tracking-wide text-left sm:w-52 sm:px-6">Tanggal Bergabung</p>
                <p class="md:block md:w-24 md:mx-6"></p>
            </div>
            @foreach ($pesertaList as $peserta)
                <div class="peserta-item flex flex-col border-t md:flex-row" data-peserta-id="{{ $peserta->id }}">
                    <div class="peserta-content flex flex-row items-center py-5 cursor-pointer md:flex-1 md:cursor-auto">
                        <p class="w-12 text-center font-medium sm:w-20 sm:px-6">{{ $loop->iteration + ($pesertaList->currentPage() - 1) * $pesertaList->perPage() }}.</p>
                        <div class="flex-1 px-2 flex flex-col">
                            <p class="nama-peserta w-fit font-medium text-gray-700">{{ $peserta->nama }}</p>
                            <p class="nik-peserta w-fit text-gray-600">{{ $peserta->nik }}</p>
                        </div>
                        <div class="w-24 sm:w-52 sm:px-6">
                            <p class="w-fit text-gray-600">{{ $peserta->created_at->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    <div class="delete-peserta-container flex flex-row justify-center items-center py-4 bg-gray-50 border-t md:flex md:w-24 md:mx-6 md:bg-white md:border-none">
                        <button type="button" class="delete-peserta button-style text-red-600 border-red-600 bg-white hover:bg-red-600 hover:text-white">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>
        <x-ui.delete-dialog :action="route('kelas.destroyPeserta', ['slug' => $kelas->slug])" class="delete-peserta-dialog">
            <x-slot:title>Hapus Peserta</x-slot>
            <x-slot:message>Apakah anda yakin ingin menghapus <span class="font-bold nama-nik-user">User</span> dari kelas ini?</x-slot>
            <x-slot:deleteMessage>
                <ul class="list-disc pl-4">
                    <li class="text-red-600">Daftar kehadiran peserta ini pada pertemuan yang sudah dilaksanakan tidak akan dihapus.</li>
                    <li class="text-red-600">Peserta ini tidak akan dimasukkan ke daftar presensi pertemuan yang akan datang.</li>
                </ul>
            </x-slot>
            <x-slot:hiddenInputs>
                <input type="hidden" name="peserta-id" value="">
            </x-slot>
        </x-ui.delete-dialog>
    </section>
    

    <section>
        {{ $pesertaList->onEachSide(2)->links() }}
    </section>

    @pushOnce('script')
        <script src="{{ asset('js/views/kelas/detail-daftar-peserta.js') }}"></script>
    @endPushOnce
</x-layouts.user-layout>