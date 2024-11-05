<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertemuanKelas extends Model
{
    protected $fillable = [
        'kelas_id',
        'ruangan_id',
        'pengajar_id',
        'pertemuan_ke',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'terlaksana',
        'topik',
        'catatan',
    ];
}
