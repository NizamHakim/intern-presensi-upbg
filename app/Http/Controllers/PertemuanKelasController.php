<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Helpers\RouteGraph;
use Illuminate\Http\Request;
use App\Models\PertemuanKelas;

class PertemuanKelasController extends Controller
{
    public function detail($slug, $id)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $pertemuan = $kelas->pertemuan()->findOrFail($id);

        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', $kelas->slug),
            "Pertemuan - $pertemuan->pertemuan_ke" => null,
        ];

        return view('kelas.pertemuan.detail-pertemuan', [
            'kelas' => $kelas,
            'pertemuan' => $pertemuan,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
