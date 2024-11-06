<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(["nama" => "Superuser"]);
        Role::create(["nama" => "Admin Pengajaran"]);
        Role::create(["nama" => "Staf Pengajar"]);
        Role::create(["nama" => "Admin Tes"]);
        Role::create(["nama" => "Staf Pengawas Tes"]);
        Role::create(["nama" => "Bagian Keuangan"]);
    }
}
