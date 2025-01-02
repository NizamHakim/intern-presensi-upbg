<x-layouts.public-layout>
  <x-slot:title>UPBG | Jadwal</x-slot>

  <section id="jadwal" class="size-full p-6 text-sm text-gray-600">
    <div class="grid size-full border">
      <div class="row-span-35 row-start-1 grid items-center">
        @foreach ($hariList as $hari)
          <div class="row-span-7">{{ $hari->isoFormat('dddd, D MMMM YYYY') }}</div>
          <div class="col-span-1 col-start-2">
            @foreach ($sesiList as $sesi)
              <div class="row-span-1">{{ $sesi['start'] }}</div>
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
  </section>

  @pushOnce('script')
  @endPushOnce
</x-layouts.public-layout>
