<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruanganList = Ruangan::paginate(10);
        return view('ruangan.daftar-ruangan', [
            'ruanganList' => $ruanganList
        ]);
    }
}
