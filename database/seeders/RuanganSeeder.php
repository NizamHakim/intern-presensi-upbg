<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ruangan::create(['kode' => 'Online', 'Kapasitas' => null]);
        Ruangan::create(['kode' => 'UPBG-101', 'Kapasitas' => 30]);
        Ruangan::create(['kode' => 'UPBG-102', 'Kapasitas' => 30]);
        Ruangan::create(['kode' => 'UPBG-103', 'Kapasitas' => 30]);
    }
}
