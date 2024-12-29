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

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}
