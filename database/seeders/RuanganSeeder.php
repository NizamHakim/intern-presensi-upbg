<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        Ruangan::create(['kode' => 'Online', 'kapasitas' => 999, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-101', 'kapasitas' => 20, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-102', 'kapasitas' => 30, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-103', 'kapasitas' => 40, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-104', 'kapasitas' => 40, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-105', 'kapasitas' => 50, 'status' => true]);
        Ruangan::create(['kode' => 'UPBG-106', 'kapasitas' => 60, 'status' => true]);
    }
}
