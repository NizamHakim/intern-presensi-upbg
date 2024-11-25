<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\JadwalKelas;
use Illuminate\Database\Seeder;
use Database\Seeders\TipeKelasSeeder;
use Database\Seeders\LevelKelasSeeder;
use App\Helpers\PertemuanKelasGenerator;
use Database\Seeders\ProgramKelasSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProgramKelasSeeder::class,
            TipeKelasSeeder::class,
            LevelKelasSeeder::class,
            RuanganSeeder::class,
            PesertaSeeder::class,
        ]);

        $nizam = User::where('nik', '5025211209')->first();
        $roles = Role::all();
        $nizam->roles()->attach($roles);
        $nizam->update(['current_role_id' => 2]);

        $other = User::where('nik', '!=', '5025211209')->get();
        foreach($other as $user){
            $randomRole = $roles->random(2);
            $user->roles()->attach($randomRole);
            $user->update(['current_role_id' => $randomRole->first()->id]);
        }

        $kelasList = Kelas::factory()
        ->count(20)
        ->has(JadwalKelas::factory()->startingDate(), 'jadwal')
        ->has(JadwalKelas::factory()->notStartingDate(), 'jadwal')
        ->create();

        $stafPengajar = User::whereHas('roles', function($query){
            return $query->where('role_id', 3);
        })->get();

        $peserta = Peserta::all();

        foreach($kelasList as $kelas){
            $nizam->mengajarKelas()->attach($kelas->id);
            $stafPengajar->random()->mengajarKelas()->attach($kelas->id);
            $kelas->peserta()->attach($peserta->random(30));
            PertemuanKelasGenerator::generate($kelas);
        }
    }
}
