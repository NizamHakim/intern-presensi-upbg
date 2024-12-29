<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        Ruangan::create(['kode' => 'Online', 'kapasitas' => 1, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-101', 'kapasitas' => 30, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-102', 'kapasitas' => 30, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-103', 'kapasitas' => 30, 'status' => true]);
    }
}
