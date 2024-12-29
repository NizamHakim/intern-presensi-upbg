<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nik' => '5025211209',
            'nama' => 'Nizam Hakim Santoso',
            'nama_panggilan' => 'Nizam',
            'email' => 'nizamhakim282@gmail.com',
            'no_hp' => '082131958278',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->count(20)->create();
    }
}
