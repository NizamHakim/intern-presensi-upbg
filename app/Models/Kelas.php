<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Kelas extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kode',
        'slug',
        'program_id',
        'tipe_id',
        'level_id',
        'ruangan_id',
        'nomor_kelas',
        'banyak_pertemuan',
        'tanggal_mulai',
        'group_link'
    ];

    public function scopeStatus(Builder $query, string $status): void
    {
        if($status == 'completed'){
            $query->whereColumn('banyak_pertemuan', '=', 'progress');
        }elseif($status == 'upcoming'){
            $query->where('progress', '=', 0);
        }elseif($status == 'inprogress'){
            $query->where('progress', '>', 0)->whereColumn('progress', '<', 'banyak_pertemuan');
        }
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalKelas::class)->orderBy('hari', 'asc');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function pengajar()
    {
        return $this->belongsToMany(User::class, 'pengajar_kelas')->withTimestamps();
    }

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'peserta_kelas')->withTimestamps();
    }

    public function pertemuan()
    {
        return $this->hasMany(PertemuanKelas::class);
    }
}
