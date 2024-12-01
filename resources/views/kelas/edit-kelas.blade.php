<x-layouts.user-layout>
    <x-slot:title>{{ $kelas->kode }} | Edit</x-slot>
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-[2rem]">Edit Kelas</h1>
        </div>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    @push('script')
    @endpush
</x-layouts.user-layout>