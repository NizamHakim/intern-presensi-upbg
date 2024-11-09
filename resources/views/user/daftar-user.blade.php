<x-layouts.user-layout>
    <x-slot:title>Daftar User</x-slot>
    <h1 class="font-semibold text-upbg text-3xl mb-4">Daftar User</h1>
    <form action="{{ route('user.index') }}" method="GET" class="flex flex-col gap-4">
        <div class="flex flex-row gap-2">
            <div class="w-80">
                <x-inputs.dropdown :options="$roleOptions" :selected="$roleSelected" label="Role" inputName="role"/>
            </div>
            <x-inputs.categorical-search :options="$searchOptions" :selected="$searchSelected" placeholder="Cari User" value="{{ $searchValue }}" class="self-end"/>
            <button type="submit" class="h-10 self-end bg-upbg transition duration-300 hover:bg-upbg-dark text-white px-3 py-2 rounded-md">
                <span><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</span>
            </button>
        </div>
    </form>

    <table class="w-full table-fixed hidden lg:table mt-8 shadow-strong">
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
                            <span href="#" class="text-gray-600 font-semibold">{{ $loop->iteration + ($usersList->currentPage() - 1) * $usersList->perPage() }}.</span>
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