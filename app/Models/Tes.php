<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tes extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'slug',
        'tipe_id',
        'ruangan_id',
        'nomor',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'terlaksana',
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

    protected function hadirCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->peserta()->wherePivot('hadir', true)->count(),
        );
    }

    public function tipe()
    {
        return $this->belongsTo(TipeTes::class, 'tipe_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'peserta_tes')->withTimestamps()->withPivot(['hadir', 'nilai']);
    }

    public function pengawas()
    {
        return $this->belongsToMany(User::class, 'pengawas_tes')->withTimestamps();
    }
}
