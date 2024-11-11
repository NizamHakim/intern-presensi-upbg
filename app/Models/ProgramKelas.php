<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramKelas extends Model
{
    use SoftDeletes;
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
