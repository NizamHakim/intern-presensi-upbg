<?php

namespace Database\Factories;

use App\Models\Ruangan;
use App\Models\TipeTes;
use App\Helpers\KodeTesGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tes>
 */
class TesFactory extends Factory
{
    public function definition(): array
    {
        $tipe = TipeTes::inRandomOrder()->first();
        $ruangan = Ruangan::inRandomOrder()->first();
        $nomor = strval(fake()->numberBetween(1, 99));
        $tanggal = now()->addDays(fake()->numberBetween(0, 1));
        $waktuMulai = fake()->time('H:i:s', 'now');
        $waktuSelesai = fake()->time('H:i:s', 'now');
        
        $kode = KodeTesGenerator::generate($tipe, $nomor, $tanggal);
        $slug = KodeTesGenerator::slug($kode);

        return [
            'kode' => $kode,
            'slug' => $slug,
            'tipe_id' => $tipe->id,
            'ruangan_id' => $ruangan->id,
            'nomor' => $nomor,
            'tanggal' => $tanggal,
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'terlaksana' => false,
        ];
    }
}
