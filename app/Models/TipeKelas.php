<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeKelas extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'aktif',
    ];
}
