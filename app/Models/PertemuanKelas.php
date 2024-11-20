<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function tanggal(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::createFromDate($value),
        );
    }

    protected function waktuMulai(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::createFromFormat('Y-m-d H:i:s', $this->tanggal->format('Y-m-d') . ' ' . $this->attributes['waktu_mulai']),
        );
    }

    protected function waktuSelesai(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::createFromFormat('Y-m-d H:i:s', $this->tanggal->format('Y-m-d') . ' ' . $this->attributes['waktu_selesai']),
        );
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function pengajar()
    {
        return $this->belongsTo(User::class, 'pengajar_id');
    }

    public function presensi()
    {
        return $this->hasMany(PresensiPertemuanKelas::class);
    }
}
