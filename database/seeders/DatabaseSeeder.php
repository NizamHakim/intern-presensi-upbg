<?php

namespace Database\Seeders;

use App\Models\Tes;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\Ruangan;
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
            TipeTesSeeder::class,
        ]);

        $nizam = User::where('nik', '5025211209')->first();
        $roles = Role::all();
        $nizam->roles()->attach($roles);
        $nizam->update(['current_role_id' => null]);

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

        $tesList = Tes::factory()->count(20)->create();

        $stafPengawas = User::whereHas('roles', function($query){
            return $query->where('role_id', 5);
        })->get();

        $ruangan = Ruangan::where('id', '!=', 1)->get();

        foreach($tesList as $tes){
            $n = rand(1, 3);
            $tes->ruangan()->attach($ruangan->random($n));
            $m = rand(1, 3);
            $tes->pengawas()->attach($stafPengawas->random($m));
            for($i = 0; $i < $n; $i++){
              $tes->peserta()->attach($peserta->random(10), ['ruangan_id' => $tes->ruangan->random()->id]);
            }
        }
    }
}
