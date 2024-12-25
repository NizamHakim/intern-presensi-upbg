<?php

namespace Database\Seeders;

use App\Models\TipeTes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeTesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeTes::create(['nama' => 'EFL', 'kode' => 'EFL']);
        TipeTes::create(['nama' => 'British Council English Score', 'kode' => 'BCES']);
        TipeTes::create(['nama' => 'ITP', 'kode' => 'ITP']);
        TipeTes::create(['nama' => 'TOEIC', 'kode' => 'TOEIC']);
        TipeTes::create(['nama' => 'IELTS', 'kode' => 'IELTS']);
        TipeTes::create(['nama' => 'Sertifikasi Dosen', 'kode' => 'SD']);
        TipeTes::create(['nama' => 'EIC', 'kode' => 'EIC']);
        TipeTes::create(['nama' => 'Bahasa Jepang', 'kode' => 'JP']);
        TipeTes::create(['nama' => 'Bahasa Mandarin', 'kode' => 'M']);
        TipeTes::create(['nama' => 'Bahasa Jerman', 'kode' => 'JE']);
        TipeTes::create(['nama' => 'Bahasa Arab', 'kode' => 'AR']);
        TipeTes::create(['nama' => 'Bahasa Prancis', 'kode' => 'F']);
    }
}
