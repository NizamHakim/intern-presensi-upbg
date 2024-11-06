<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JadwalKelas>
 */
class JadwalKelasFactory extends Factory
{
    public function definition(): array
    {
        $waktuMulai = fake()->time();
        $waktuSelesai = Carbon::createFromTimeString($waktuMulai)->addHours(2);
        return [
            'hari' => fake()->numberBetween(0, 6),
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai
        ];
    }

    public function startingDate(): Factory
    {
        return $this->state(function (array $attributes, Kelas $kelas){
            return [
                'hari' => $kelas->tanggal_mulai->dayOfWeek,
            ];
        });
    }

    public function notStartingDate(): Factory
    {
        return $this->state(function (array $attributes, Kelas $kelas){
            $hari = fake()->numberBetween(0, 6);
            while ($hari === $kelas->tanggal_mulai->dayOfWeek) {
                $hari = fake()->numberBetween(0, 6);
            }
            return [
                'hari' => $hari,
            ];
        });
    }
}
