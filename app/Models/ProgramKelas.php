<?php

namespace App\Models;

use App\Models\Scopes\Aktif;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class ProgramKelas extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama', 
        'kode',
        'aktif',
    ];

    public function scopeAktif(Builder $query): void
    {
        $query->where('aktif', 1);
    }

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

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}
