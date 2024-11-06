<?php

namespace Database\Seeders;

use App\Models\LevelKelas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LevelKelas::create(['nama' => 'Semua', 'kode' => '']);
        LevelKelas::create(['nama' => 'Beginner', 'kode' => 'B']);
        LevelKelas::create(['nama' => 'Elementary', 'kode' => 'E']);
        LevelKelas::create(['nama' => 'Intermediate', 'kode' => 'I']);
        LevelKelas::create(['nama' => 'Advanced', 'kode' => 'A']);
        LevelKelas::create(['nama' => 'BIS 1', 'kode' => 'BIS1']);
        LevelKelas::create(['nama' => 'BIS 2', 'kode' => 'BIS2']);
        LevelKelas::create(['nama' => 'BIS 3', 'kode' => 'BIS3']);
        LevelKelas::create(['nama' => 'BIAP 1', 'kode' => 'BIAP1']);
        LevelKelas::create(['nama' => 'BIAP 2', 'kode' => 'BIAP2']);
        LevelKelas::create(['nama' => 'BIAP 3', 'kode' => 'BIAP3']);
        LevelKelas::create(['nama' => '1', 'kode' => '1']);
        LevelKelas::create(['nama' => '2', 'kode' => '2']);
        LevelKelas::create(['nama' => '3', 'kode' => '3']);
    }
}
