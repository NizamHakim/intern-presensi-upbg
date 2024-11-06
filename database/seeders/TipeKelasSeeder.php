<?php

namespace Database\Seeders;

use App\Models\TipeKelas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TipeKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeKelas::create(['nama' => 'General English', 'kode' => 'GE']);
        TipeKelas::create(['nama' => 'General English Apps', 'kode' => 'GE.Apps']);
        TipeKelas::create(['nama' => 'TOEFL Preparation', 'kode' => 'TP']);
        TipeKelas::create(['nama' => 'TOEIC Preparation', 'kode' => 'TOEIC']);
        TipeKelas::create(['nama' => 'IELTS Preparation', 'kode' => 'IELTS']);
        TipeKelas::create(['nama' => 'Duolingo Preparation', 'kode' => 'DUOLINGO']);
        TipeKelas::create(['nama' => 'Conversation', 'kode' => 'C']);
        TipeKelas::create(['nama' => 'Academic Writing', 'kode' => 'AW']);
        TipeKelas::create(['nama' => 'Kids Class', 'kode' => 'K']);
        TipeKelas::create(['nama' => 'Bahasa Indonesia untuk Penutur Asing', 'kode' => 'BIPA']);
        TipeKelas::create(['nama' => 'Japanese', 'kode' => 'JP']);
        TipeKelas::create(['nama' => 'Mandarin', 'kode' => 'M']);
        TipeKelas::create(['nama' => 'German', 'kode' => 'JE']);
        TipeKelas::create(['nama' => 'Arabic', 'kode' => 'AR']);
        TipeKelas::create(['nama' => 'French', 'kode' => 'F']);
        TipeKelas::create(['nama' => 'Korean', 'kode' => 'KR']);
    }
}
