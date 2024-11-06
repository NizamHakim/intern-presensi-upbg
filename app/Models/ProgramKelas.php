<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProgramKelas extends Model
{
    protected $fillable = [
        'nama', 
        'kode',
        'aktif',
    ];

    protected function text(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['nama'] . ' (' . $attributes['kode'] .  ')'
        );
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => strtolower($attributes['kode'])
        );
    }
}
