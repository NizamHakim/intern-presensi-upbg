<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PresensiPertemuanKelas extends Model
{
    protected $fillable=[
        'pertemuan_id',
        'peserta_id',
        'hadir',
    ];

    public function pertemuan()
    {
        return $this->belongsTo(PertemuanKelas::class, 'pertemuan_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
