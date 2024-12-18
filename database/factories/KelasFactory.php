<?php

namespace Database\Factories;

use App\Helpers\KodeKelasGenerator;
use App\Models\LevelKelas;
use App\Models\ProgramKelas;
use App\Models\Ruangan;
use App\Models\TipeKelas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $program = ProgramKelas::inRandomOrder()->first();
        $tipe = TipeKelas::inRandomOrder()->first();
        $level = ($tipe->kode == 'C') ? null : LevelKelas::inRandomOrder()->first();
        $ruangan = Ruangan::inRandomOrder()->first();
        $nomorKelas = strval(fake()->numberBetween(1, 99));
        $banyakPertemuan = fake()->randomElement([16, 24]);
        $tanggalMulai = now()->addDays(fake()->numberBetween(0, 1));

        $kode = KodeKelasGenerator::generate(
            $program->kode,
            $tipe->kode,
            $nomorKelas,
            $level->kode ?? '',
            $banyakPertemuan,
            $tanggalMulai
        );

        $slug = KodeKelasGenerator::slug($kode);

        $groupLink = 'https://chat.whatsapp.com/###########';

        return [
            'kode' => $kode,
            'slug' => $slug,
            'program_id' => $program->id,
            'tipe_id' => $tipe->id,
            'level_id' => $level->id,
            'ruangan_id' => $ruangan->id,
            'nomor_kelas' => $nomorKelas,
            'banyak_pertemuan' => $banyakPertemuan,
            'tanggal_mulai' => $tanggalMulai,
            'group_link' => $groupLink,
        ];
    }
}
