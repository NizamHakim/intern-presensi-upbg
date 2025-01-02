<div class="grid grid-cols-12 items-center gap-x-3 py-4">
  <p class="col-span-2 pl-2 text-center font-semibold sm:col-span-1">No.</p>
  <p class="col-span-5 font-semibold sm:col-span-6">Peserta</p>
  <p class="col-span-3 font-semibold sm:col-span-4">Status Kehadiran</p>
</div>
@if ($pesertaList->isEmpty())
  <p class="py-4 text-center">Tidak ada data yang cocok</p>
@else
  @foreach ($pesertaList as $peserta)
    <div class="peserta-item grid grid-cols-12 items-center gap-x-3 py-5" data-peserta-id="{{ $peserta->id }}">
      <p class="col-span-2 pl-2 text-center font-medium sm:col-span-1">{{ $loop->iteration }}.</p>
      <div class="col-span-5 sm:col-span-6">
        <p class="nama-peserta w-fit font-medium text-gray-700">{{ $peserta->nama }}</p>
        <p class="nik-peserta w-fit text-gray-600">{{ $peserta->nik }}</p>
      </div>
      <form action="{{ route('tes.updatePresensi', ['slug' => $tes->slug, 'pesertaId' => $peserta->id]) }}" class="form-toggle-kehadiran col-span-3 sm:col-span-4">
        @if ($peserta->pivot->hadir)
          <button type="submit" name="hadir" value="1" class="btn-hadir btn-rounded btn-white active">H</button>
          <button type="submit" name="hadir" value="0" class="btn-alfa btn-rounded btn-white">A</button>
        @else
          <button type="submit" name="hadir" value="1" class="btn-hadir btn-rounded btn-white">H</button>
          <button type="submit" name="hadir" value="0" class="btn-alfa btn-rounded btn-white active">A</button>
        @endif
      </form>
      <div class="relative col-span-2 text-center sm:col-span-1">
        <button type="button" class="menu btn-rounded btn-white border-none shadow-none"><i class="fa-solid fa-ellipsis-vertical"></i></button>
        <x-ui.dialog class="right-1/2 top-full mt-1 translate-x-4">
          <button type="button" class="delete-peserta w-full px-2 py-1.5 text-left text-red-600 hover:bg-gray-100">Delete</button>
        </x-ui.dialog>
      </div>
    </div>
  @endforeach
@endif
