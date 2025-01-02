<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruangan extends Model
{
  use SoftDeletes;
  protected $table = "ruangan";
  protected $fillable = [
      'kode',
      'kapasitas',
      'status'
  ];

  public function scopeAktif(Builder $query): void
  {
      $query->where('status', 1);
  }

  public function kelas()
  {
      return $this->hasMany(Kelas::class);
  }

  public function pertemuan()
  {
      return $this->hasMany(PertemuanKelas::class);
  }

  public function tes()
  {
      return $this->belongsToMany(Tes::class, 'ruangan_test')->withTimestamps();
  }

  public function pesertaTes()
  {
      return $this->hasMany(PesertaTes::class);
  }
}
