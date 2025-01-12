<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Tes extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'slug',
        'tipe_id',
        'nomor',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'terlaksana',
    ];

    public function scopeStatus(Builder $query, string $status): void
    {
        switch($status){
            case 'completed':
                $query->where('tanggal', '<=', Carbon::today())->where('waktu_selesai', '<=', Carbon::now());
                break;
            case 'in-progress':
                $query->where('tanggal', '=', Carbon::today())->where('waktu_mulai', '<=', Carbon::now())->where('waktu_selesai', '>=', Carbon::now());
                break;
            case 'upcoming':
                $query->where('tanggal', '>', Carbon::today())->orWhere(function($query){
                    $query->where('tanggal', '=', Carbon::today())->where('waktu_mulai', '>', Carbon::now());
                });
                break;
        }
    }

    public function scopeSort(Builder $query, string $sort): void
    {
        switch($sort){
            case 'tanggal-desc':
                $query->orderBy('tanggal', 'desc')->orderBy('waktu_mulai', 'asc');
                break;
            case 'tanggal-asc':
                $query->orderBy('tanggal', 'asc')->orderBy('waktu_mulai', 'asc');
                break;
            case 'kode-asc':
                $query->orderBy('kode', 'asc');
                break;
            case 'kode-desc':
                $query->orderBy('kode', 'desc');
                break;
        }
    }

    protected function tanggal(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::createFromDate($value),
        );
    }

    protected function waktuMulai(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::createFromFormat('Y-m-d H:i:s', $this->tanggal->format('Y-m-d') . ' ' . $this->attributes['waktu_mulai']),
        );
    }

    protected function waktuSelesai(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::createFromFormat('Y-m-d H:i:s', $this->tanggal->format('Y-m-d') . ' ' . $this->attributes['waktu_selesai']),
        );
    }

    protected function hadirCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->peserta()->wherePivot('hadir', true)->count(),
        );
    }

    public function tipe()
    {
        return $this->belongsTo(TipeTes::class, 'tipe_id')->withTrashed();
    }

    public function ruangan()
    {
        return $this->belongsToMany(Ruangan::class, 'ruangan_tes')->withTimestamps()->withTrashed();
    }

    public function pengawas()
    {
        return $this->belongsToMany(User::class, 'pengawas_tes')->withTimestamps()->withTrashed();
    }

    public function pivotPeserta()
    {
        return $this->hasMany(PesertaTes::class, 'tes_id')->orderBy('id', 'desc');
    }
}
