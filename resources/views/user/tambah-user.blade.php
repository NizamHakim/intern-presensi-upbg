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
        <div class="flex flex-col gap-4">
            <button type="submit" class="relative mt-2 text-white font-semibold px-3 py-2 bg-green-600 rounded-md shadow-[0px_3px] shadow-green-700 transition ease-linear transform translate-y-0 cursor-pointer active:shadow-none active:translate-y-1">Tambah</button>
            <a href="{{ route('user.index') }}" class="relative text-center text-gray-400 font-semibold border border-gray-400 px-3 py-2 bg-white rounded-md shadow-none transition duration-300 hover:shadow-md">Cancel</a>
        </div>
    </form>

    @push('script')
        <script src="{{ asset('js/utils/form-control.js') }}"></script>
        <script src="{{ asset('js/views/user/tambah-user.js') }}"></script>
    @endpush
</x-layouts.user-layout>