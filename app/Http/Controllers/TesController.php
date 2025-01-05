<?php

namespace App\Http\Controllers;

use App\Helpers\KodeTesGenerator;
use App\Models\PesertaTes;
use App\Models\Tes;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\TipeTes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function Illuminate\Log\log;

class TesController extends Controller
{
    public function index(Request $request)
    {
        $tipeOptions = TipeTes::aktif()->get();
        $ruanganOptions = Ruangan::aktif()->get();
        $pengawasOptions = User::pengawas()->get();

        $statusOptions = collect([
          ['text' => 'Completed', 'value' => 'completed'],
          ['text' => 'In Progress', 'value' => 'in-progress'],
          ['text' => 'Upcoming', 'value' => 'upcoming'],
        ]);

        $sortbyOptions = collect([
          ['text' => 'Tanggal Tes (Terjauh)', 'value' => 'tanggal-desc'],
          ['text' => 'Tanggal Tes (Terdekat)', 'value' => 'tanggal-asc'],
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
            return $query->sort('tanggal-asc');
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

        $tesList->with('ruangan');
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

        $breadcrumbs = [
            'Tes' => route('tes.index'),
            'Tambah Tes' => route('tes.create')
        ];

        return view('tes.tambah-tes', [
            'tipeOptions' => $tipeOptions,
            'pengawasOptions' => $pengawasOptions,
            'ruanganOptions' => $ruanganOptions,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'kode-tes' => 'required|unique:tes,kode',
        'tipe' => 'required|exists:tipe_tes,id',
        'nomor-tes' => 'required|numeric',
        'tanggal' => 'required|date',
        'waktu-mulai' => 'required|date_format:H:i',
        'waktu-selesai' => 'required|date_format:H:i',
        'ruangan' => 'required|array',
        'ruangan.*' => 'required|exists:ruangan,id',
        'pengawas' => 'required|array',
        'pengawas.*' => 'required|exists:users,id',
      ], [
        'kode-tes.required' => 'Kode tes tidak boleh kosong',
        'kode-tes.unique' => 'Kode tes sudah digunakan',
        'tipe.required' => 'Tipe tes tidak boleh kosong',
        'tipe.exists' => 'Tipe tes tidak valid',
        'nomor-tes.required' => 'Nomor tes tidak boleh kosong',
        'nomor-tes.numeric' => 'Nomor tes harus berupa angka',
        'tanggal.required' => 'Tanggal tes tidak boleh kosong',
        'tanggal.date' => 'Tanggal tes tidak valid',
        'waktu-mulai.required' => 'Waktu mulai tes tidak boleh kosong',
        'waktu-mulai.date_format' => 'Waktu mulai tes tidak valid',
        'waktu-selesai.required' => 'Waktu selesai tes tidak boleh kosong',
        'waktu-selesai.date_format' => 'Waktu selesai tes tidak valid',
        'ruangan.required' => 'Ruangan tidak boleh kosong',
        'ruangan.*.required' => 'Ruangan tidak boleh kosong',
        'ruangan.*.exists' => 'Ruangan tidak valid',
        'pengawas.required' => 'Pengawas tidak boleh kosong',
        'pengawas.*.required' => 'Pengawas tidak boleh kosong',
        'pengawas.*.exists' => 'Pengawas tidak valid',
      ]);

      if ($validator->fails()) {
        return response($validator->errors(), 422);
      }

      $tes = Tes::create([
        'kode' => $request['kode-tes'],
        'slug' => KodeTesGenerator::slug($request['kode-tes']),
        'tipe_id' => $request['tipe'],
        'nomor' => $request['nomor-tes'],
        'tanggal' => $request['tanggal'],
        'waktu_mulai' => $request['waktu-mulai'],
        'waktu_selesai' => $request['waktu-selesai'],
      ]);

      $tes->ruangan()->attach($request['ruangan']);
      $tes->pengawas()->attach($request['pengawas']);

      return response([
        'message' => "Tes $tes->kode berhasil ditambahkan",
        'redirect' => route('tes.index'),
      ], 200);
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

    public function edit($slug)
    {
      $tes = Tes::with('ruangan', 'pengawas')->where('slug', $slug)->firstOrFail();
      $tipeOptions = TipeTes::all();
      $pengawasOptions = User::pengawas()->get();
      $ruanganOptions = Ruangan::aktif()->get();

      $breadcrumbs = [
          'Tes' => route('tes.index'),
          $tes->kode => route('tes.detail', $tes->slug),
          'Edit' => route('tes.edit', $tes->slug)
      ];

      return view('tes.edit-detail', [
          'tes' => $tes,
          'tipeOptions' => $tipeOptions,
          'pengawasOptions' => $pengawasOptions,
          'ruanganOptions' => $ruanganOptions,
          'breadcrumbs' => $breadcrumbs
      ]);
    }

    public function update($slug, Request $request)
    {
       $tes = Tes::where('slug', $slug)->first();
       if(!$tes){
           return response([
               'message' => 'Tes tidak ditemukan, silahkan refresh dan coba lagi',
           ], 404);
       }

       $validator = Validator::make($request->all(), [
        'kode-tes' => 'required|unique:tes,kode,' . $tes->id,
        'tipe' => 'required|exists:tipe_tes,id',
        'nomor-tes' => 'required|numeric',
        'tanggal' => 'required|date',
        'waktu-mulai' => 'required|date_format:H:i',
        'waktu-selesai' => 'required|date_format:H:i',
        'ruangan' => 'required|array',
        'ruangan.*' => 'required|exists:ruangan,id',
        'pengawas' => 'required|array',
        'pengawas.*' => 'required|exists:users,id',
      ], [
        'kode-tes.required' => 'Kode tes tidak boleh kosong',
        'kode-tes.unique' => 'Kode tes sudah digunakan',
        'tipe.required' => 'Tipe tes tidak boleh kosong',
        'tipe.exists' => 'Tipe tes tidak valid',
        'nomor-tes.required' => 'Nomor tes tidak boleh kosong',
        'nomor-tes.numeric' => 'Nomor tes harus berupa angka',
        'tanggal.required' => 'Tanggal tes tidak boleh kosong',
        'tanggal.date' => 'Tanggal tes tidak valid',
        'waktu-mulai.required' => 'Waktu mulai tes tidak boleh kosong',
        'waktu-mulai.date_format' => 'Waktu mulai tes tidak valid',
        'waktu-selesai.required' => 'Waktu selesai tes tidak boleh kosong',
        'waktu-selesai.date_format' => 'Waktu selesai tes tidak valid',
        'ruangan.required' => 'Ruangan tidak boleh kosong',
        'ruangan.*.required' => 'Ruangan tidak boleh kosong',
        'ruangan.*.exists' => 'Ruangan tidak valid',
        'pengawas.required' => 'Pengawas tidak boleh kosong',
        'pengawas.*.required' => 'Pengawas tidak boleh kosong',
        'pengawas.*.exists' => 'Pengawas tidak valid',
      ]);

      if ($validator->fails()) {
        return response($validator->errors(), 422);
      }

      // $tes->update([
      //   'kode' => $request['kode-tes'],
      //   'slug' => KodeTesGenerator::slug($request['kode-tes']),
      //   'tipe_id' => $request['tipe'],
      //   'nomor' => $request['nomor-tes'],
      //   'tanggal' => $request['tanggal'],
      //   'waktu_mulai' => $request['waktu-mulai'],
      //   'waktu_selesai' => $request['waktu-selesai'],
      // ]);

      $tes->ruangan()->sync($request['ruangan']);
      $pesertaStray = $tes->peserta()->whereNotIn('ruangan_id', $request['ruangan'])->get();
      // return response($pesertaStray, 200);

      foreach($tes->ruangan as $ruangan){
        $kapasitas = $ruangan->kapasitas;
        $pesertaCount = $tes->peserta()->wherePivot('ruangan_id', $ruangan->id)->count();
        $sisa = $kapasitas - $pesertaCount;
        log($kapasitas);
        log($pesertaCount);
        log($sisa);

        if ($sisa > 0) {
          $toAssign = $pesertaStray->take($sisa)->pluck('id')->toArray();
          log($toAssign);
          $tes->peserta()->syncWithoutDetaching(array_fill_keys($toAssign, ['ruangan_id' => $ruangan->id]));
          log(array_fill_keys($toAssign, ['ruangan_id' => $ruangan->id]));
          $pesertaStray = $pesertaStray->slice($sisa);
          log($pesertaStray);
        }
      }
      // return response([
      //   'message' => "Tes $tes->kode berhasil diupdate",
      //   'redirect' => route('tes.detail', $tes->slug),
      //   'stray' => $pesertaStray,
      // ], 200);

      $tes->pengawas()->sync($request['pengawas']);

      return response([
        'message' => "Tes $tes->kode berhasil diupdate",
        'redirect' => route('tes.detail', $tes->slug),
      ], 200);
    }

    public function daftarPeserta($slug)
    {
      // $tes = Tes::where('slug', $slug)->firstOrFail();
      $tes = Tes::with(['peserta'])->where('slug', $slug)->firstOrFail();
      $pesertaList = $tes->peserta()->paginate(10);
      dump($tes->peserta[0]->pivot->ruanganTes);
      dd($pesertaList);

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
