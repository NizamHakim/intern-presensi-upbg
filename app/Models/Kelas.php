<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'kode',
        'slug',
        'program_id',
        'tipe_id',
        'level_id',
        'ruangan_id',
        'nomor_kelas',
        'banyak_pertemuan',
        'tanggal_mulai',
    ];
}
