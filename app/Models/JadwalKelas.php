<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    protected $fillable = [
        'kelas_id',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
    ];
}
