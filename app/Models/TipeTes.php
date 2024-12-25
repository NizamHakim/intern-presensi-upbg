<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class TipeTes extends Model
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

    public function tes()
    {
        return $this->hasMany(Tes::class, 'tipe_id');
    }
}
