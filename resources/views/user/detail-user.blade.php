<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    <x-slot:title>Tambah Program</x-slot>
    
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-[2rem]">Detail User</h1>
        </div>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <div class="flex flex-col p-8 gap-4 shadow-strong" data-user-id="{{ $user->id }}">
        <div class="size-40 border-2 shadow-md rounded-full overflow-hidden self-center">
            <img src="{{ ($user->profile_picture) ? asset('storage/' . $user->profile_picture) : asset('images/defaultProfilePicture.png') }}" class="rounded-full">
        </div>
        <div class="flex flex-col gap-1">
            <p class="font-semibold text-gray-800 text-sm">Nama</p>
            <p class="text-base text-gray-600 font-medium">{{ $user->nama }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <p class="font-semibold text-gray-800 text-sm">NIK / NIP</p>
            <p class="text-base text-gray-600 font-medium">{{ $user->nik }}</p>
        </div>
        <div class="flex flex-col gap-1">
            <p class="font-semibold text-gray-800 text-sm">Email</p>
            <a href="mailto:{{ $user->email }}" class="text-upbg underline decoration-transparent transition hover:decoration-upbg font-medium">{{ $user->email }}</a>
        </div>
        <div class="flex flex-col gap-1">
            <p class="font-semibold text-gray-800 text-sm">No. HP / Whatsapp</p>
            <a href="{{ 'http://wa.me/62' . substr($user->no_hp, 1) }}" target="_blank" class="text-upbg underline decoration-transparent transition hover:decoration-upbg font-medium">{{ $user->no_hp }}</a>
        </div>
        <div class="flex flex-col">
            <p class="font-semibold text-gray-800 text-sm">Roles</p>
            <div class="flex flex-col gap-4 mt-3">
                @foreach ($roleOptions as $role)
                   <x-inputs.checkbox inputName="role" :value="$role->id" :checked="$user->roles->contains('id', $role->id)" :label="$role->nama" class="checked:bg-upbg checked:border-upbg"/> 
                @endforeach
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('js/views/user/detail-user.js') }}"></script>
    @endpush
</x-layouts.user-layout>