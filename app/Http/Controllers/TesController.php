<?php

namespace App\Http\Controllers;

use App\Models\PesertaTes;
use App\Models\Tes;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\TipeTes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TesController extends Controller
{
    public function index(Request $request)
    {
        $tipeOptions = TipeTes::aktif()->get();
        $ruanganOptions = Ruangan::aktif()->get();
        $pengawasOptions = User::pengawas()->get();

        $statusOptions = collect([
          ['text' => 'Completed', 'value' => 'completed'],
          ['text' => 'Upcoming', 'value' => 'upcoming'],
        ]);

        $sortbyOptions = collect([
          ['text' => 'Tanggal Tes (Terbaru)', 'value' => 'tanggal-desc'],
          ['text' => 'Tanggal Tes (Terlama)', 'value' => 'tanggal-asc'],
          ['text' => 'Kode Tes (A-Z)', 'value' => 'kode-asc'],
          ['text' => 'Kode Tes (Z-A)', 'value' => 'kode-desc'],
        ]);

        $tesList = Tes::query();

        $tesList->when($request->query('tipe'), function($query) use ($request){
            return $query->where('tipe_id', $request->query('tipe'));
        });

        $tesList->when($request->query('nomor'), function($query) use ($request){
          return $query->where('nomor', $request->query('nomor'));
        });

        $tesList->when($request->query('tanggal'), function($query) use ($request){
          $firstDate = Carbon::parse($request->query('tanggal'))->startOfMonth();
          $lastDate = Carbon::parse($request->query('tanggal'))->endOfMonth();
          return $query->whereBetween('tanggal', [$firstDate, $lastDate]);
        });

        $tesList->when($request->query('ruangan'), function($query) use ($request){
          return $query->whereHas('ruangan', function($query) use ($request){
            return $query->where('ruangan_id', $request->query('ruangan'));
          });
        });

        $tesList->when($request->query('status'), function($query) use ($request){
          return $query->status($request->query('status'));
        });

        $tesList->when($request->query('order'), function($query) use ($request){
          return $query->sort($request->query('order'));
        }, function($query){
            return $query->latest();
        });

        $tesList->when($request->query('kode'), function($query) use ($request){
          return $query->where('kode', 'like', '%' . $request->query('kode') . '%');
        });

        if(Auth::user()->current_role_id == 4){        
          $tesList->when($request->query('pengawas'), function($query) use ($request){
              return $query->whereHas('pengawas', function($query) use ($request){
                  $query->where('user_id', $request->query('pengawas'));
              });
          });
        }else{
            $tesList->whereHas('pengawas', function($query){
                $query->where('user_id', Auth::id());
            });
        }

        $tesList = $tesList->paginate(10)->appends($request->all());

        $selected = [
            'tipe' => TipeTes::find($request->query('tipe')),
            'nomor' => $request->query('nomor'),
            'tanggal' => $request->query('tanggal'),
            'ruangan' => Ruangan::find($request->query('ruangan')),
            'status' => $statusOptions->where('value', $request->query('status'))->first(),
            'order' => $sortbyOptions->where('value', $request->query('order'))->first(),
            'kode' => $request->query('kode'),
            'pengawas' => User::find($request->query('pengawas')),
        ];

        return view('tes.daftar-tes', [
            'tesList' => $tesList,
            'tipeOptions' => $tipeOptions,
            'ruanganOptions' => $ruanganOptions,
            'pengawasOptions' => $pengawasOptions,
            'statusOptions' => $statusOptions,
            'sortbyOptions' => $sortbyOptions,
            'selected' => $selected
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

    public function detail($slug, Request $request)
    {
      
      $tes = Tes::where('slug', $slug)->first();
      
      if($request->ajax()){
        $pesertaList = ($request->query('ruangan')) ? $tes->peserta()->wherePivot('ruangan_id', $request->query('ruangan'))->get() : $tes->peserta;
        return view('tes.partials.presensi-peserta', [
          'pesertaList' => $pesertaList,
          'tes' => $tes
        ])->render();
      }

      $breadcrumbs = [
          'Tes' => route('tes.index'),
          $tes->kode => route('tes.detail', $tes->slug)
      ];

      $pesertaList = $tes->peserta;

      return view('tes.detail-tes', [
          'tes' => $tes,
          'pesertaList' => $pesertaList,
          'breadcrumbs' => $breadcrumbs
      ]);
    }

    public function daftarPeserta($slug)
    {
      $tes = Tes::where('slug', $slug)->firstOrFail();
      $pesertaList = $tes->peserta()->paginate(10);

      $breadcrumbs = [
          'Tes' => route('tes.index'),
          $tes->kode => route('tes.detail', $tes->slug),
          'Daftar Peserta' => route('tes.daftarPeserta', $tes->slug)
      ];

      return view('tes.detail-daftar-peserta', [
          'tes' => $tes,
          'pesertaList' => $pesertaList,
          'breadcrumbs' => $breadcrumbs
      ]);
    }

    public function updateRuangan($slug, Request $request)
    {
      $tes = Tes::where('slug', $slug)->firstOrFail();
      
      $validator = Validator::make($request->all(), [
        'peserta-id' => 'required|exists:peserta,id',
        'ruangan-id' => 'required|exists:ruangan,id',
      ]);
      
      if ($validator->fails()) {
        return response($validator->errors(), 422);
      }

      $tes->peserta()->updateExistingPivot($request['peserta-id'], [
        'ruangan_id' => $request['ruangan-id'],
      ]);

      $updated = PesertaTes::where('tes_id', $tes->id)
      ->join('ruangan', 'peserta_tes.ruangan_id', '=', 'ruangan.id')
      ->groupBy('peserta_tes.ruangan_id', 'ruangan.kapasitas') // Add ruangan.kapasitas to GROUP BY
      ->select('peserta_tes.ruangan_id as ruangan', 'ruangan.kapasitas as kapasitas', PesertaTes::raw('count(peserta_tes.ruangan_id) as total'))
      ->get();
      
      return response([
          'updated' => $updated,
      ], 200);
    }

    public function updatePresensi($slug, $pesertaId, Request $request)
    {
      $tes = Tes::where('slug', $slug)->firstOrFail();
      
      $validator = Validator::make($request->all(), [
        'hadir' => 'required|boolean',
      ]);
      
      if ($validator->fails()) {
        return response($validator->errors(), 422);
      }

      
      $tes->peserta()->updateExistingPivot($pesertaId, [
        'hadir' => $request['hadir'],
      ]);

      return response([
          'hadir' => $tes->hadirCount,
          'total' => $tes->peserta()->count(),
      ], 200);
    }

    public function destroyPresensi($slug, Request $request)
    {
      $tes = Tes::where('slug', $slug)->firstOrFail();
      
      $validator = Validator::make($request->all(), [
        'peserta-id' => 'required|exists:peserta_tes,peserta_id',
      ]);
      
      if ($validator->fails()) {
        return response($validator->errors(), 422);
      }

      $tes->peserta()->detach($request['peserta-id']);

      return response([
          'message' => 'Peserta berhasil dihapus',
          'redirect' => route('tes.detail', $tes->slug),
      ], 200);
    }
}
