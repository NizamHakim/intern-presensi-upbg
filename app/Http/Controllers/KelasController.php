<?php

namespace App\Http\Controllers;

use App\Helpers\RouteGraph;
use App\Models\Kelas;
use App\Models\Ruangan;
use App\Models\TipeKelas;
use App\Models\LevelKelas;
use App\Models\ProgramKelas;
use Illuminate\Http\Request;
use App\Models\PertemuanKelas;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ItemNotFoundException;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $programOptions = ProgramKelas::aktif()->get()->map->only(['text', 'value'])->prepend(['text' => 'Semua', 'value' => null]);
        $programSelected = ($request->query('program') != null) ? ProgramKelas::where('kode', $request->query('program'))->firstOrFail() : null;

        $tipeOptions = TipeKelas::aktif()->get()->map->only(['text', 'value'])->prepend(['text' => 'Semua', 'value' => null]);
        $tipeSelected = ($request->query('tipe') != null) ? TipeKelas::where('kode', $request->query('tipe'))->firstOrFail() : null;

        $levelOptions = LevelKelas::aktif()->get()->map->only(['text', 'value']);
        if($levelOptions->where('value', null)->isEmpty()){
            $levelOptions->prepend(['text' => 'Semua', 'value' => null]);
        }
        $levelSelected = ($request->query('level') != null) ? LevelKelas::where('kode', $request->query('level'))->firstOrFail() : null;

        $ruanganOptions = Ruangan::all()->map->only(['text', 'value'])->prepend(['text' => 'Semua', 'value' => null]);
        $ruanganSelected = ($request->query('ruangan') != null) ? Ruangan::where('kode', $request->query('ruangan'))->firstOrFail() : null;
        
        $pengajarOptions = User::whereHas('roles', function($query){
            $query->where('role_id', 3);
        })->get()->map->only(['text', 'value'])->prepend(['text' => 'Semua', 'value' => null]);;
        $pengajarSelected = ($request->query('pengajar') != null) ? User::whereHas('mengajarKelas', function($query) use ($request){
            $query->where('user_id', $request->query('pengajar'));
        })->firstOrFail() : null;

        $statusOptions = collect([
            ['text' => 'Semua', 'value' => ''],
            ['text' => 'In Progress', 'value' => 'inprogress'],
            ['text' => 'Completed', 'value' => 'completed'],
            ['text' => 'Upcoming', 'value' => 'upcoming'],
        ]);
        if($request->query('status') != null){
            try{
                $statusSelected = $statusOptions->where('value', $request->query('status'))->firstOrFail();
            }catch(ItemNotFoundException $e){
                abort(404);
            }
        }else{
            $statusSelected = null;
        }

        $sortByOptions = collect([
            ['text' => 'Tanggal mulai (terbaru)', 'value' => 'latest'],
            ['text' => 'Tanggal mulai (terlama)', 'value' => 'oldest'],
        ]);
        if($request->query('sort-by') != null){
            try{
                $sortBySelected = $sortByOptions->where('value', $request->query('sort-by'))->firstOrFail();
            }catch(ItemNotFoundException $e){
                abort(404);
            }
        }else{
            $sortBySelected = null;
        }

        $nomor = $request->query('nomor');
        $banyakPertemuan = $request->query('banyak-pertemuan');
        $tanggalMulai = $request->query('tanggal-mulai');

        
        $progress = PertemuanKelas::select('kelas_id', DB::raw('COUNT(id) AS progress'))
        ->where('terlaksana', true)
        ->groupBy('kelas_id');

        $kelasList = Kelas::with(['jadwal', 'ruangan'])
        ->joinSub($progress, 'progress', function ($join) {
            $join->on('kelas.id', '=', 'progress.kelas_id');
        })->when($programSelected != null, function($query) use ($programSelected){
            return $query->where('program_id', $programSelected->id);
        })->when($tipeSelected != null, function($query) use ($tipeSelected){
            return $query->where('tipe_id', $tipeSelected->id);
        })->when($levelSelected != null, function($query) use ($levelSelected){
            return $query->where('level_id', $levelSelected->id);
        })->when($ruanganSelected != null, function($query) use ($ruanganSelected){
            return $query->where('ruangan_id', $ruanganSelected->id);
        })->when($nomor != null, function($query) use ($nomor){
            return $query->where('nomor_kelas', $nomor);
        })->when($banyakPertemuan != null, function($query) use ($banyakPertemuan){
            return $query->where('banyak_pertemuan', $banyakPertemuan);
        })->when($tanggalMulai != null, function($query) use ($tanggalMulai){
            return $query->whereBetween('tanggal_mulai', [
                Carbon::parse($tanggalMulai)->startOfMonth(),
                Carbon::parse($tanggalMulai)->endOfMonth(),
            ]);
        })->when($pengajarSelected != null, function($query) use ($pengajarSelected){
            return $query->whereHas('pengajar', function($query) use ($pengajarSelected){
                return $query->where('user_id', $pengajarSelected->id);
            });
        })->when($statusSelected != null, function($query) use ($statusSelected){
            return $query->status($statusSelected['value']);
        })->when($sortBySelected != null, function($query) use ($sortBySelected){
            if($sortBySelected['value'] == 'latest'){
                return $query->orderBy('tanggal_mulai', 'desc');
            }elseif($sortBySelected['value'] == 'oldest'){
                return $query->orderBy('tanggal_mulai', 'asc');
            }
        }, function($query){
            return $query->orderBy('tanggal_mulai', 'desc');
        })->paginate(10)->appends(array_filter($request->query(), function($value){
            return $value !== null;
        }));

        return view('kelas.daftar-kelas', [
            'programOptions' => $programOptions,
            'programSelected' => $programSelected ? $programSelected->only(['text', 'value']) : $programOptions[0],
            'tipeOptions' => $tipeOptions,
            'tipeSelected' => $tipeSelected ? $tipeSelected->only(['text', 'value']) : $tipeOptions[0],
            'levelOptions' => $levelOptions,
            'levelSelected' => $levelSelected ? $levelSelected->only(['text', 'value']) : $levelOptions[0],
            'ruanganOptions' => $ruanganOptions,
            'ruanganSelected' => $ruanganSelected ? $ruanganSelected->only(['text', 'value']) : $ruanganOptions[0],
            'pengajarOptions' => $pengajarOptions,
            'pengajarSelected' => $pengajarSelected ? $pengajarSelected->only(['text', 'value']) : $pengajarOptions[0],
            'statusOptions' => $statusOptions,
            'statusSelected' => $statusSelected ?? $statusOptions[0],
            'sortByOptions' => $sortByOptions,
            'sortBySelected' => $sortBySelected ?? $sortByOptions[0],
            'nomor' => $nomor,
            'banyakPertemuan' => $banyakPertemuan,
            'tanggalMulai' => $tanggalMulai,
            'kelasList' => $kelasList,
        ]);
    }

    public function detail($slug)
    {
        $kelas = Kelas::with(['jadwal', 'pengajar', 'pertemuan' => ['ruangan']])->where('slug', $slug)->firstOrFail();
        $kelas->progress = $kelas->pertemuan->where('terlaksana', true)->count();
        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => null,
        ];

        $ruanganOptions = Ruangan::all();
        $ruanganSelected = null;
        
        return view('kelas.detail-daftar-pertemuan', [
            'kelas' => $kelas,
            'breadcrumbs' => $breadcrumbs,
            'ruanganOptions' => $ruanganOptions,
            'ruanganSelected' => $ruanganSelected,
        ]);
    }

    public function daftarPeserta($slug)
    {
        $kelas = Kelas::with(['jadwal', 'pengajar', 'pertemuan' => ['ruangan']])->where('slug', $slug)->firstOrFail();
        $kelas->progress = $kelas->pertemuan->where('terlaksana', true)->count();
        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => null,
        ];

        $pesertaList = $kelas->peserta()->paginate(10);
        
        return view('kelas.detail-daftar-peserta', [
            'kelas' => $kelas,
            'breadcrumbs' => $breadcrumbs,
            'pesertaList' => $pesertaList,
        ]);
    }

    public function store(Request $request)
    {
        
    }

    public function edit($slug)
    {
        $kelas = Kelas::with(['jadwal', 'pengajar', 'pertemuan' => ['ruangan']])->where('slug', $slug)->firstOrFail();

        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', ['slug' => $kelas->slug]),
            'Edit' => null,
        ];

        $programOptions = ProgramKelas::aktif()->get();
        $programSelected = null;
        $tipeOptions = TipeKelas::aktif()->get();
        $tipeSelected = null;
        $levelOptions = LevelKelas::aktif()->get();
        $levelSelected = null;
        $ruanganOptions = Ruangan::all();
        $ruanganSelected = null;
        $pengajarOptions = User::pengajar()->get();
        $pengajarSelected = null;

        return view('kelas.edit-kelas', [
            'kelas' => $kelas,
            'breadcrumbs' => $breadcrumbs,
            'programOptions' => $programOptions,
            'programSelected' => $programSelected,
            'tipeOptions' => $tipeOptions,
            'tipeSelected' => $tipeSelected,
            'levelOptions' => $levelOptions,
            'levelSelected' => $levelSelected,
            'ruanganOptions' => $ruanganOptions,
            'ruanganSelected' => $ruanganSelected,
            'pengajarOptions' => $pengajarOptions,
            'pengajarSelected' => $pengajarSelected,
        ]);
    }

    public function update($slug, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'kode-kelas' => 'required|string|max:255',
            'program-kode' => 'required|string|exists:table,column',
        ], [
            
        ]);
    }

    public function destroyPeserta($slug, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $kelas->peserta()->detach($request['peserta-id']);

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Peserta berhasil dihapus dari kelas ' . $kelas->kode
        ]);

        return redirect()->route('kelas.daftarPeserta', ['slug' => $kelas->slug]);
    }

    public function destroy($slug)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $kelas->delete();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Kelas ' . $kelas->kode . ' berhasil dihapus'
        ]);

        return redirect()->route('kelas.index');
    }
}
