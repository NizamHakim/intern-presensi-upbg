<x-layouts.user-layout>
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    <x-slot:title>Tambah Program</x-slot>
    
    <div class="flex flex-col gap-4 mt-6 mb-8">
        <div class="flex flex-row justify-between items-center">
            <h1 class="font-bold text-upbg text-[2rem]">Tambah User</h1>
        </div>
        <x-ui.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    </div>

    <form id="form-tambah" action="{{ route('user.store') }}" method="POST" class="flex flex-col gap-6 mb-16" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="flex flex-col self-center">
            <label for="foto-user" class="relative border-2 size-44 cursor-pointer rounded-full shadow-md">
                <div class="size-44 cursor-pointer rounded-full overflow-hidden">
                    <img src="{{ asset('images/defaultProfilePicture.png') }}" class="image-preview rounded-full">
                </div>
                <div class="absolute flex flex-row justify-center items-center bottom-1 right-1 size-10 rounded-full bg-upbg">
                    <i class="fa-solid fa-camera text-white"></i>
                </div>
            </label>
            <input id="foto-user" type="file" accept="image/png, image/jpeg, image/jpg" class="input-image hidden" name="foto-user">
            <p class="text-center text-sm mt-2 text-gray-600">(opsional)</p>
            <x-inputs.cropper-image/>
        </div>
        <div class="flex flex-col gap-1">
            <label for="nik-user" class="font-medium text-gray-600">NIK / NIP</label>
            <input id="nik-user" type="text" name="nik-user" placeholder="NIK / NIP" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
        </div>
        <div class="flex flex-col gap-1">
            <label for="nama-user" class="font-medium text-gray-600">Nama</label>
            <input id="nama-user" type="text" name="nama-user" placeholder="Nama" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
        </div>
        <div class="flex flex-col gap-1">
            <label for="email-user" class="font-medium text-gray-600">Email</label>
            <input id="email-user" type="text" name="email-user" placeholder="Email" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
        </div>
        <div class="flex flex-row gap-4 w-full">
            <div class="flex flex-col gap-1 w-full">
                <label for="password-user" class="font-medium text-gray-600">Password</label>
                <input id="password-user" type="password" name="password-user" placeholder="Password" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
            </div>
            <div class="flex flex-col gap-1 w-full">
                <label for="password-confirm-user" class="font-medium text-gray-600">Konfirmasi Password</label>
                <input id="password-confirm-user" type="password" name="password-confirm-user" placeholder="Konfirmasi Password" class="px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light">
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <label class="font-medium text-gray-600">Role(s)</label>
            @foreach ($roleOptions as $role)
                <x-inputs.checkbox inputName="role[]" value="{{ $role->id }}" :checked="false" label="{{ $role->nama }}" class="checked:bg-upbg checked:border-upbg-upbg"/>
            @endforeach
        </div>
        <hr class="bg-gray-200 my-5">
        <div class="flex flex-row justify-end items-center gap-4">
            <a href="{{ route('user.index') }}" class="relative text-center text-gray-600 font-medium px-8 py-2 bg-gray-100 hover:bg-gray-200 rounded-md transition duration-300">Cancel</a>
            <button type="submit" class="bg-green-600 shadow-md transition duration-300 hover:bg-green-700 text-base px-8 py-2 font-medium text-white rounded-md">Tambah</button>
        </div>
    </form>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/user/tambah-user.js') }}"></script>
    @endpush
</x-layouts.user-layout>