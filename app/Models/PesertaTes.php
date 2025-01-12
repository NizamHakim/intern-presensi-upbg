<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class PesertaTes extends Model
// {
//     protected $table = 'peserta_tes';

//     protected $fillable = [
//         'tes_id',
//         'peserta_id',
//         'ruangan_id',
//         'hadir',
//     ];

//     public function tes()
//     {
//         return $this->belongsTo(Tes::class, 'tes_id');
//     }

//     public function peserta()
//     {
//         return $this->belongsTo(Peserta::class, 'peserta_id');
//     }

//     public function ruanganTes()
//     {
//         return $this->belongsTo(Ruangan::class, 'ruangan_id')->withTrashed();
//     }
// }
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

    public function tes()
    {
        return $this->belongsTo(Tes::class, 'tes_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function ruanganTes()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id')->withTrashed();
    }
}
