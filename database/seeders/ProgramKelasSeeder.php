<?php

namespace Database\Seeders;

use App\Models\ProgramKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramKelas::create(['nama' => 'Reguler', 'kode' => 'REG']);
        ProgramKelas::create(['nama' => 'Special Class', 'kode' => 'SP']);
        ProgramKelas::create(['nama' => 'IKOMA', 'kode' => 'IKOMA.REG']);
    }
}
