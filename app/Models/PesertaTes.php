<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PesertaTes extends Pivot
{
    protected $table = 'peserta_tes';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'tes_id',
        'peserta_id',
        'ruangan_id',
        'hadir',
    ];

    public function ruanganTes()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id')->withTrashed();
    }
}
