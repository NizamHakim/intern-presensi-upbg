<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';
    protected $fillable = [
        'nik',
        'nama',
        'occupation',
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'peserta_kelas');
    }

    public function presensi()
    {
        return $this->hasMany(PresensiPertemuanKelas::class, 'peserta_id');
    }
}
