<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresensiPertemuanKelas extends Model
{
    protected $fillable=[
        'pertemuan_id',
        'peserta_id',
        'hadir',
    ];

    public function pertemuan()
    {
        return $this->belongsTo(PertemuanKelas::class);
    }
}
