<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ruangan extends Model
{
    protected $table = "ruangan";
    protected $fillable = [
        'kode',
        'kapasitas',
    ];

    protected function text(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['kode']
        );
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => strtolower($attributes['kode'])
        );
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function pertemuan()
    {
        return $this->hasMany(PertemuanKelas::class);
    }
}
