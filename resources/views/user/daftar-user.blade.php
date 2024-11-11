<x-layouts.user-layout>
    <x-slot:title>Daftar User</x-slot>
    <div class="flex flex-row justify-between items-center gap-4 mt-6 mb-6">
        <h1 class="font-bold text-upbg text-[2rem]">Daftar User</h1>
        <a href="#" class="relative text-white font-semibold px-3 py-2 bg-green-600 rounded-md shadow-[0px_3px] shadow-green-700 transition ease-linear transform translate-y-0 cursor-pointer active:shadow-none active:translate-y-1">
            <i class="fa-solid fa-plus mr-2"></i>
            Tambah User
        </a>
    </div>

    <form action="{{ route('user.index') }}" method="GET" class="flex flex-row gap-4">
        <div class="w-60">
            <x-inputs.dropdown :options="$roleOptions" :selected="$roleSelected" label="Role" inputName="role"/>
        </div>
        <x-inputs.categorical-search :options="$searchOptions" :selected="$searchSelected" placeholder="Cari User" value="{{ $searchValue }}" class="self-end"/>
        <button type="submit" class="h-10 self-end bg-upbg transition duration-300 hover:bg-upbg-dark text-white px-3 py-2 rounded-md">
            <span><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</span>
        </button>
    </form>

    <table class="w-full table-fixed hidden lg:table mt-10 shadow-strong">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-3 py-4 lg:w-28 text-gray-600 font-semibold tracking-wide text-center">No</th>
                <th class="px-3 py-4 text-gray-600 font-semibold tracking-wide text-left">User</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @if ($usersList->isEmpty())
                <tr>
                    <td class="px-3 py-4 text-center font-medium text-gray-400" colspan="4">Tidak ada user yang cocok</td>
                </tr>
            @else
                @foreach ($usersList as $user)
                    <tr class="bg-white transition hover:bg-gray-100">
                        <td class="px-3 py-4 xl:w-28 text-center">
                            <span class="text-gray-600 font-semibold">{{ $loop->iteration + ($usersList->currentPage() - 1) * $usersList->perPage() }}.</span>
                        </td>
                        <td class="px-3 py-4 xl:w-72">
                            <div class="flex flex-row gap-8">
                                <img src="{{ asset($user->profile_picture) }}" alt="profile-picture" class="size-16">
                                <div class="flex flex-col justify-center">
                                    <a href="#" class="text-upbg underline decoration-transparent transition hover:decoration-upbg font-semibold">{{ $user->nama }}</a>
                                    <p class="text-gray-400 text-sm font-medium">{{ $user->nik }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="mb-10">
        {{ $usersList->onEachSide(2)->links() }}
    </div>
</x-layouts.user-layout>