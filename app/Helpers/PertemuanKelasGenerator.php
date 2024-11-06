<?php

namespace App\Helpers;

use App\Models\Kelas;

class PertemuanKelasGenerator
{
    public static function generate(Kelas $kelas): void
    {
        $firstDay = $kelas->tanggal_mulai->dayOfWeek;
        $jadwal = $kelas->jadwal;

        while($firstDay !== $jadwal[0]->hari){
            $jadwal->push($jadwal->shift());
        }
        $jadwal->push($jadwal->shift());

        $tanggal = $kelas->tanggal_mulai->copy();
        $mod = count($jadwal);

        for($i = 0; $i < $kelas->banyak_pertemuan; $i++){
            $kelas->pertemuan()->create([
                'ruangan_id' => $kelas->ruangan_id,
                'pertemuan_ke' => $i + 1,
                'tanggal' => $tanggal,
                'waktu_mulai' => $jadwal[$i % $mod]->waktu_mulai,
                'waktu_selesai' => $jadwal[$i % $mod]->waktu_selesai,
                'terlaksana' => fake()->randomElement([true, false]),
            ]);
            $tanggal->next($jadwal[$i % $mod]->hari);
        }
    }
}