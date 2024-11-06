<?php

namespace App\Http\Controllers;

use App\Models\LevelKelas;
use App\Models\ProgramKelas;
use App\Models\Ruangan;
use App\Models\TipeKelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $programOptions = ProgramKelas::all()
            ->map->only(['text', 'value'])
            ->prepend(['text' => 'Semua', 'value' => null]);
        $programSelected = ($request->query('program') != null) 
            ? ProgramKelas::where('kode', $request->query('program'))->firstOrFail()->only(['text', 'value'])
            : $programOptions->first();

        $tipeOptions = TipeKelas::all()
            ->map->only(['text', 'value'])
            ->prepend(['text' => 'Semua', 'value' => null]);
        $tipeSelected = ($request->query('tipe') != null) 
            ? TipeKelas::where('kode', $request->query('tipe'))->firstOrFail()->only(['text', 'value'])
            : $tipeOptions->first();

        $levelOptions = LevelKelas::all()
            ->map->only(['text', 'value']);
        $levelSelected = ($request->query('level') != null) 
            ? LevelKelas::where('kode', $request->query('level'))->firstOrFail()->only(['text', 'value'])
            : $levelOptions->first();

        $ruanganOptions = Ruangan::all()
            ->map->only(['text', 'value'])
            ->prepend(['text' => 'Semua', 'value' => null]);
        $ruanganSelected = ($request->query('ruangan') != null)
            ? Ruangan::where('kode', $request->query('ruangan'))->firstOrFail()->only(['text', 'value'])
            : $ruanganOptions->first();
        
        $statusOptions = collect([
            ['text' => 'Semua', 'value' => ''],
            ['text' => 'In Progress', 'value' => 'inprogress'],
            ['text' => 'Completed', 'value' => 'completed'],
            ['text' => 'Upcoming', 'value' => 'upcoming'],
        ]);
        $statusSelected = ($request->query('status') != null) 
        ? $statusOptions->where('value', $request->query('status'))->first() 
        : $statusOptions->first();

        $sortByOptions = collect([
            ['text' => 'Tanggal mulai (terbaru)', 'value' => 'latest'],
            ['text' => 'Tanggal mulai (terlama)', 'value' => 'oldest'],
        ]);
        $sortBySelected = ($request->query('sortBy') != null) 
            ? $sortByOptions->where('value', $request->query('sortBy'))->first() 
            : $sortByOptions->first();
        

        $nomor = $request->query('nomor');
        $banyakPertemuan = $request->query('$banyakPertemuan');
        $tanggalMulai = $request->query('tanggalMulai');


        return view('kelas.daftar-kelas', [
            'programOptions' => $programOptions,
            'programSelected' => $programSelected,
            'tipeOptions' => $tipeOptions,
            'tipeSelected' => $tipeSelected,
            'levelOptions' => $levelOptions,
            'levelSelected' => $levelSelected,
            'ruanganOptions' => $ruanganOptions,
            'ruanganSelected' => $ruanganSelected,
            'statusOptions' => $statusOptions,
            'statusSelected' => $statusSelected,
            'sortByOptions' => $sortByOptions,
            'sortBySelected' => $sortBySelected,
            'nomor' => $nomor,
            'banyakPertemuan' => $banyakPertemuan,
            'tanggalMulai' => $tanggalMulai,
        ]);
    }
}
