<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsToMany(Kelas::class, 'peserta_kelas')->withPivot('aktif');
    }

    public function presensi()
    {
        return $this->hasMany(PresensiPertemuanKelas::class, 'peserta_id');
    }

    public function pivotTes()
    {
        return $this->hasMany(PesertaTes::class, 'peserta_id');
    }
}
