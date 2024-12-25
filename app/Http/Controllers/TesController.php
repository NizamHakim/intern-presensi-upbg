<?php

namespace App\Http\Controllers;

use App\Models\Tes;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\TipeTes;

class TesController extends Controller
{
    public function index()
    {
        $tesList = Tes::all();
        return view('tes.daftar-tes', [
            'tesList' => $tesList
        ]);
    }

    public function create()
    {
        $tipeOptions = TipeTes::all();
        $pengawasOptions = User::pengawas()->get();
        $ruanganOptions = Ruangan::all();
        $hariOptions = collect([
            ['text' => 'Minggu', 'value' => 0],
            ['text' => 'Senin', 'value' => 1],
            ['text' => 'Selasa', 'value' => 2],
            ['text' => 'Rabu', 'value' => 3],
            ['text' => 'Kamis', 'value' => 4],
            ['text' => 'Jumat', 'value' => 5],
            ['text' => 'Sabtu', 'value' => 6],
        ]);

        $breadcrumbs = [
            'Tes' => route('tes.index'),
            'Tambah Tes' => route('tes.create')
        ];

        return view('tes.tambah-tes', [
            'tipeOptions' => $tipeOptions,
            'pengawasOptions' => $pengawasOptions,
            'ruanganOptions' => $ruanganOptions,
            'hariOptions' => $hariOptions,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function detail($slug)
    {
        $tes = Tes::where('slug', $slug)->first();
        $breadcrumbs = [
            'Tes' => route('tes.index'),
            $tes->kode => route('tes.detail', $tes->slug)
        ];

        return view('tes.detail-tes', [
            'tes' => $tes,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
