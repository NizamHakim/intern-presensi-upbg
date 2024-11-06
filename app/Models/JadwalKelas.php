<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKelas extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kelas_id',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
    ];

    protected function namaHari(): Attribute
    {
        $hariArr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $hariArr[$attributes['hari']],
        );
    }

    protected function waktuMulai(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::createFromTimeString($value),
        );
    }

    protected function waktuSelesai(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::createFromTimeString($value),
        );
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
