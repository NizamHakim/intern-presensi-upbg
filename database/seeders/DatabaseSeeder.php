<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TipeKelasSeeder;
use Database\Seeders\LevelKelasSeeder;
use Database\Seeders\ProgramKelasSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProgramKelasSeeder::class,
            TipeKelasSeeder::class,
            LevelKelasSeeder::class,
            RuanganSeeder::class,
        ]);
    }
}
