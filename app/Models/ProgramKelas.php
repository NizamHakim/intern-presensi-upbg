<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKelas extends Model
{
    protected $fillable = [
        'nama', 
        'kode',
        'aktif',
    ];
}
