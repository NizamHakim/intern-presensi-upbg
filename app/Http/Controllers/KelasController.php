<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Ruangan;
use App\Models\TipeKelas;
use App\Models\LevelKelas;
use App\Helpers\RouteGraph;
use App\Models\ProgramKelas;
use Illuminate\Http\Request;
use App\Models\PertemuanKelas;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\KodeKelasGenerator;
use App\Helpers\PertemuanKelasGenerator;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $programOptions = ProgramKelas::aktif()->get();
        $tipeOptions = TipeKelas::aktif()->get();
        $levelOptions = LevelKelas::aktif()->get();
        $ruanganOptions = Ruangan::aktif()->get();
        $pengajarOptions = User::pengajar()->get();

        // query in Kelas.php model
        $statusOptions = collect([
            ['text' => 'Completed', 'value' => 'completed'],
            ['text' => 'In Progress', 'value' => 'in-progress'],
            ['text' => 'Upcoming', 'value' => 'upcoming'],
        ]);

        // query in Kelas.php model
        $sortbyOptions = collect([
            ['text' => 'Tanggal Mulai (Terbaru)', 'value' => 'tanggal-mulai-desc'],
            ['text' => 'Tanggal Mulai (Terlama)', 'value' => 'tanggal-mulai-asc'],
            ['text' => 'Kode Kelas (A-Z)', 'value' => 'kode-asc'],
            ['text' => 'Kode Kelas (Z-A)', 'value' => 'kode-desc'],
        ]);

        $progress = PertemuanKelas::select('kelas_id', DB::raw('SUM(terlaksana=1) as progress'))->groupBy('kelas_id');
        $kelasList = Kelas::with(['ruangan', 'jadwal']);
        $kelasList->joinSub($progress, 'progress', function($join){
            $join->on('kelas.id', '=', 'progress.kelas_id');
        });

        $kelasList->when($request->query('program'), function($query) use ($request){
            return $query->where('program_id', $request->query('program'));
        });

        $kelasList->when($request->query('tipe'), function($query) use ($request){
            return $query->where('tipe_id', $request->query('tipe'));
        });

        $kelasList->when($request->query('nomor'), function($query) use ($request){
            return $query->where('nomor_kelas', $request->query('nomor'));
        });

        $kelasList->when($request->query('level'), function($query) use ($request){
            return $query->where('level_id', $request->query('level'));
        });

        $kelasList->when($request->query('banyak-pertemuan'), function($query) use ($request){
            return $query->where('banyak_pertemuan', $request->query('banyak-pertemuan'));
        });

        $kelasList->when($request->query('tanggal-mulai'), function($query) use ($request){
            $firstDate = Carbon::parse($request->query('tanggal-mulai'))->startOfMonth();
            $lastDate = Carbon::parse($request->query('tanggal-mulai'))->endOfMonth();
            return $query->whereBetween('tanggal_mulai', [$firstDate, $lastDate]);
        });

        $kelasList->when($request->query('ruangan'), function($query) use ($request){
            return $query->where('ruangan_id', $request->query('ruangan'));
        });

        $kelasList->when($request->query('status'), function($query) use ($request){
            return $query->status($request->query('status'));
        });

        $kelasList->when($request->query('order'), function($query) use ($request){
            return $query->sort($request->query('order'));
        }, function($query){
            return $query->latest();
        });

        $kelasList->when($request->query('kode'), function($query) use ($request){
            return $query->where('kode', 'like', '%' . $request->query('kode') . '%');
        });

        if(Auth::user()->current_role_id == 2){        
            $kelasList->when($request->query('pengajar'), function($query) use ($request){
                return $query->whereHas('pengajar', function($query) use ($request){
                    $query->where('user_id', $request->query('pengajar'));
                });
            });
        }else{
            $kelasList->whereHas('pengajar', function($query){
                $query->where('user_id', Auth::id());
            });
        }

        $kelasList = $kelasList->paginate(10)->appends($request->all());

        $selected = [
            'program' => ProgramKelas::find($request->query('program')),
            'tipe' => TipeKelas::find($request->query('tipe')),
            'nomor' => $request->query('nomor'),
            'level' => LevelKelas::find($request->query('level')),
            'banyak-pertemuan' => $request->query('banyak-pertemuan'),
            'tanggal-mulai' => $request->query('tanggal-mulai'),
            'ruangan' => Ruangan::find($request->query('ruangan')),
            'status' => $statusOptions->where('value', $request->query('status'))->first(),
            'sortby' => $sortbyOptions->where('value', $request->query('order'))->first(),
            'pengajar' => User::find($request->query('pengajar')),
            'kode' => $request->query('kode'),
        ];

        return view('kelas.daftar-kelas', [
            'programOptions' => $programOptions,
            'tipeOptions' => $tipeOptions,
            'levelOptions' => $levelOptions,
            'ruanganOptions' => $ruanganOptions,
            'pengajarOptions' => $pengajarOptions,
            'statusOptions' => $statusOptions,
            'sortbyOptions' => $sortbyOptions,
            'kelasList' => $kelasList,
            'selected' => $selected,
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
        
        return view('kelas.detail-daftar-pertemuan', [
            'kelas' => $kelas,
            'breadcrumbs' => $breadcrumbs,
            'ruanganOptions' => $ruanganOptions,
        ]);
    }

    public function create()
    {
        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            'Tambah' => null,
        ];

        $programOptions = ProgramKelas::aktif()->get();
        $tipeOptions = TipeKelas::aktif()->get();
        $levelOptions = LevelKelas::aktif()->get();
        $ruanganOptions = Ruangan::all();
        $pengajarOptions = User::pengajar()->get();
        $hariOptions = collect([
            ['text' => 'Minggu', 'value' => 0],
            ['text' => 'Senin', 'value' => 1],
            ['text' => 'Selasa', 'value' => 2],
            ['text' => 'Rabu', 'value' => 3],
            ['text' => 'Kamis', 'value' => 4],
            ['text' => 'Jumat', 'value' => 5],
            ['text' => 'Sabtu', 'value' => 6],
        ]);

        return view('kelas.tambah-kelas', [
            'breadcrumbs' => $breadcrumbs,
            'programOptions' => $programOptions,
            'tipeOptions' => $tipeOptions,
            'levelOptions' => $levelOptions,
            'ruanganOptions' => $ruanganOptions,
            'pengajarOptions' => $pengajarOptions,
            'hariOptions' => $hariOptions,
        ]);
    }

    public function store(Request $request)
    {
        Validator::extend('jadwal_include_tanggal_mulai', function($attribute, $value, $parameters, $validator){
            $tanggalMulai = Carbon::parse($parameters[0]);
            $hariArray = $value;

            $result = false;
            foreach($hariArray as $hari){
                if($tanggalMulai->dayOfWeek == $hari){
                    $result = true;
                    break;
                }
            }
            return $result;
        });

        $validator = Validator::make($request->all(), [
            'kode-kelas' => 'required|unique:kelas,kode',
            'program' => 'required|exists:program_kelas,id',
            'tipe' => 'required|exists:tipe_kelas,id',
            'nomor-kelas' => 'required|numeric',
            'level' => 'nullable|exists:level_kelas,id',
            'banyak-pertemuan' => 'required|numeric',
            'tanggal-mulai' => 'required|date',
            'ruangan' => 'required|exists:ruangan,id',
            'group-link' => 'nullable|url:https',
            'hari' => 'required|array|jadwal_include_tanggal_mulai:' . $request['tanggal-mulai'],
            'hari.*' => 'required|numeric',
            'waktu-mulai' => 'required|array',
            'waktu-mulai.*' => 'required|date_format:H:i',
            'waktu-selesai' => 'required|array',
            'waktu-selesai.*' => 'required|date_format:H:i',
            'pengajar' => 'required|array',
            'pengajar.*' => 'required|exists:users,id',
            'nik-peserta' => 'nullable|array',
            'nik-peserta.*' => 'required|numeric',
            'nama-peserta' => 'nullable|array',
            'nama-peserta.*' => 'required',
            'occupation-peserta' => 'nullable|array',
            'occupation-peserta.*' => 'required',
        ], [ 
            'kode-kelas.required' => 'Kode kelas tidak boleh kosong',
            'kode-kelas.unique' => 'Kode kelas sudah digunakan',
            'program.required' => 'Program tidak boleh kosong',
            'program.exists' => 'Program tidak valid',
            'tipe.required' => 'Tipe tidak boleh kosong',
            'tipe.exists' => 'Tipe tidak valid',
            'nomor-kelas.required' => 'Nomor kelas tidak boleh kosong',
            'nomor-kelas.numeric' => 'Nomor kelas harus berupa angka',
            'level.exists' => 'Level tidak valid',
            'banyak-pertemuan.required' => 'Banyak pertemuan tidak boleh kosong',
            'banyak-pertemuan.numeric' => 'Banyak pertemuan harus berupa angka',
            'tanggal-mulai.required' => 'Tanggal mulai tidak boleh kosong',
            'tanggal-mulai.date' => 'Tanggal mulai tidak valid',
            'ruangan.required' => 'Ruangan tidak boleh kosong',
            'ruangan.exists' => 'Ruangan tidak valid',
            'group-link.url' => 'Link harus dalam format https',
            'hari.required' => 'Hari tidak boleh kosong',
            'hari.jadwal_include_tanggal_mulai' => 'Salah satu jadwal harus mencakup hari tanggal mulai',
            'hari.*.required' => 'Hari tidak boleh kosong',
            'hari.*.numeric' => 'Hari tidak valid',
            'waktu-mulai.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.*.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.*.date_format' => 'Waktu mulai tidak valid',
            'waktu-selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu-selesai.*.required' => 'Waktu selesai tidak boleh kosong',
            'pengajar.required' => 'Pengajar tidak boleh kosong',
            'pengajar.*.required' => 'Pengajar tidak boleh kosong',
            'pengajar.*.exists' => 'Pengajar tidak valid',
            'nik-peserta.*.required' => 'NIK / NRP tidak boleh kosong',
            'nik-peserta.*.numeric' => 'NIK / NRP harus berupa angka',
            'nama-peserta.*.required' => 'Nama tidak boleh kosong',
            'occupation-peserta.*.required' => 'Departemen / Occupation tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $kelas = Kelas::create([
            'kode' => $request['kode-kelas'],
            'slug' => KodeKelasGenerator::slug($request['kode-kelas']),
            'program_id' => $request['program'],
            'tipe_id' => $request['tipe'],
            'nomor_kelas' => $request['nomor-kelas'],
            'level_id' => $request['level'],
            'banyak_pertemuan' => $request['banyak-pertemuan'],
            'tanggal_mulai' => $request['tanggal-mulai'],
            'ruangan_id' => $request['ruangan'],
            'group_link' => $request['group-link'],
        ]);

        for($i = 0; $i < count($request['hari']); $i++){
            $kelas->jadwal()->create([
                'hari' => $request['hari'][$i],
                'waktu_mulai' => $request['waktu-mulai'][$i],
                'waktu_selesai' => $request['waktu-selesai'][$i],
            ]);
        };

        PertemuanKelasGenerator::generate($kelas);

        $kelas->pengajar()->sync($request['pengajar']);

        for($i = 0; $i < count($request['nik-peserta']); $i++){
            $peserta = Peserta::firstOrCreate(['nik' => $request['nik-peserta'][$i]], [
                'nama' => $request['nama-peserta'][$i],
                'occupation' => $request['occupation-peserta'][$i],
            ]);

            $kelas->peserta()->attach($peserta->id);
        }

        return response([
            'redirect' => route('kelas.index'),
            'message' => "Kelas $kelas->kode berhasil ditambahkan"
        ], 200);
    }

    public function edit($slug)
    {
        $kelas = Kelas::with(['jadwal', 'pengajar'])->where('slug', $slug)->firstOrFail();

        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', ['slug' => $kelas->slug]),
            'Edit' => null,
        ];

        $programOptions = ProgramKelas::aktif()->get();
        $tipeOptions = TipeKelas::aktif()->get();
        $levelOptions = LevelKelas::aktif()->get();
        $ruanganOptions = Ruangan::all();
        $pengajarOptions = User::pengajar()->get();
        $hariOptions = collect([
            ['text' => 'Minggu', 'value' => 0],
            ['text' => 'Senin', 'value' => 1],
            ['text' => 'Selasa', 'value' => 2],
            ['text' => 'Rabu', 'value' => 3],
            ['text' => 'Kamis', 'value' => 4],
            ['text' => 'Jumat', 'value' => 5],
            ['text' => 'Sabtu', 'value' => 6],
        ]);

        return view('kelas.edit-kelas', [
            'kelas' => $kelas,
            'breadcrumbs' => $breadcrumbs,
            'programOptions' => $programOptions,
            'tipeOptions' => $tipeOptions,
            'levelOptions' => $levelOptions,
            'ruanganOptions' => $ruanganOptions,
            'pengajarOptions' => $pengajarOptions,
            'hariOptions' => $hariOptions,
        ]);
    }

    public function update($slug, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
            return response([
                'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode-kelas' => 'required|unique:kelas,kode,' . $kelas->id,
            'program' => 'required|exists:program_kelas,id',
            'tipe' => 'required|exists:tipe_kelas,id',
            'nomor-kelas' => 'required|numeric',
            'level' => 'nullable|exists:level_kelas,id',
            'banyak-pertemuan' => 'required|numeric',
            'tanggal-mulai' => 'required|date',
            'ruangan' => 'required|exists:ruangan,id',
            'group-link' => 'nullable|url:https',
            'hari' => 'required|array',
            'hari.*' => 'required|numeric',
            'waktu-mulai' => 'required|array',
            'waktu-mulai.*' => 'required|date_format:H:i',
            'waktu-selesai' => 'required|array',
            'waktu-selesai.*' => 'required|date_format:H:i',
            'pengajar' => 'required|array',
            'pengajar.*' => 'required|exists:users,id',
        ], [ 
            'kode-kelas.required' => 'Kode kelas tidak boleh kosong',
            'kode-kelas.unique' => 'Kode kelas sudah digunakan',
            'program.required' => 'Program tidak boleh kosong',
            'program.exists' => 'Program tidak valid',
            'tipe.required' => 'Tipe tidak boleh kosong',
            'tipe.exists' => 'Tipe tidak valid',
            'nomor-kelas.required' => 'Nomor kelas tidak boleh kosong',
            'nomor-kelas.numeric' => 'Nomor kelas harus berupa angka',
            'level.exists' => 'Level tidak valid',
            'banyak-pertemuan.required' => 'Banyak pertemuan tidak boleh kosong',
            'banyak-pertemuan.numeric' => 'Banyak pertemuan harus berupa angka',
            'tanggal-mulai.required' => 'Tanggal mulai tidak boleh kosong',
            'tanggal-mulai.date' => 'Tanggal mulai tidak valid',
            'ruangan.required' => 'Ruangan tidak boleh kosong',
            'ruangan.exists' => 'Ruangan tidak valid',
            'group-link.url' => 'Link harus dalam format https',
            'hari.required' => 'Hari tidak boleh kosong',
            'hari.*.required' => 'Hari tidak boleh kosong',
            'hari.*.numeric' => 'Hari tidak valid',
            'waktu-mulai.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.*.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.*.date_format' => 'Waktu mulai tidak valid',
            'waktu-selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu-selesai.*.required' => 'Waktu selesai tidak boleh kosong',
            'pengajar.required' => 'Pengajar tidak boleh kosong',
            'pengajar.*.required' => 'Pengajar tidak boleh kosong',
            'pengajar.*.exists' => 'Pengajar tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $kelas->update([
            'kode' => $request['kode-kelas'],
            'slug' => KodeKelasGenerator::slug($request['kode-kelas']),
            'program_id' => $request['program'],
            'tipe_id' => $request['tipe'],
            'nomor_kelas' => $request['nomor-kelas'],
            'level_id' => $request['level'],
            'banyak_pertemuan' => $request['banyak-pertemuan'],
            'tanggal_mulai' => $request['tanggal-mulai'],
            'ruangan_id' => $request['ruangan'],
            'group_link' => $request['group-link'],
        ]);

        $kelas->jadwal()->delete();
        for($i = 0; $i < count($request['hari']); $i++){
            $kelas->jadwal()->create([
                'hari' => $request['hari'][$i],
                'waktu_mulai' => $request['waktu-mulai'][$i],
                'waktu_selesai' => $request['waktu-selesai'][$i],
            ]);
        }
        
        $kelas->pengajar()->sync($request['pengajar']);

        return response([
            'redirect' => route('kelas.detail', ['slug' => $kelas->slug]),
            'message' => "Detail kelas $kelas->kode berhasil diupdate"
        ], 200);
    }

    public function destroy($slug)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $kelas->delete();

        return response([
            'redirect' => route('kelas.index'),
            'message' => "Kelas $kelas->kode berhasil dihapus" 
        ], 200);
    }

    public function daftarPeserta($slug)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', ['slug' => $kelas->slug]),
            'Daftar Peserta' => null,
        ];

        $pesertaList = $kelas->peserta()->paginate(20);
        
        return view('kelas.detail-daftar-peserta', [
            'kelas' => $kelas,
            'breadcrumbs' => $breadcrumbs,
            'pesertaList' => $pesertaList,
        ]);
    }

    public function tambahPeserta($slug)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', ['slug' => $kelas->slug]),
            'Daftar Peserta' => route('kelas.daftarPeserta', ['slug' => $kelas->slug]),
            'Tambah' => null,
        ];

        return view('kelas.tambah-peserta', [
            'kelas' => $kelas,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function storePeserta($slug, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        Validator::extend('unique_peserta', function($attribute, $value, $parameters, $validator){
            $kelas = Kelas::where('slug', $parameters[0])->first();
            $peserta = Peserta::where('nik', $value)->first();
            if(!$peserta) return true;
            return $kelas->peserta()->where('peserta_id', $peserta->id)->count() == 0;
        });

        $validator = Validator::make($request->all(), [
            'nik-peserta' => 'nullable|array',
            'nik-peserta.*' => 'required|numeric|unique_peserta:' . $kelas->slug,
            'nama-peserta' => 'nullable|array',
            'nama-peserta.*' => 'required',
            'occupation-peserta' => 'nullable|array',
            'occupation-peserta.*' => 'required',
        ], [ 
            'nik-peserta.*.required' => 'NIK / NRP tidak boleh kosong',
            'nik-peserta.*.numeric' => 'NIK / NRP harus berupa angka',
            'nik-peserta.*.unique_peserta' => 'Peserta sudah terdaftar di kelas ini',
            'nama-peserta.*.required' => 'Nama tidak boleh kosong',
            'occupation-peserta.*.required' => 'Departemen / Occupation tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }
        
        for($i = 0; $i < count($request['nik-peserta']); $i++){
            $peserta = Peserta::firstOrCreate(['nik' => $request['nik-peserta'][$i]], [
                'nama' => $request['nama-peserta'][$i],
                'occupation' => $request['occupation-peserta'][$i],
            ]);

            $kelas->peserta()->attach($peserta->id);
        }

        return response([
            'redirect' => route('kelas.daftarPeserta', ['slug' => $kelas->slug]),
            'message' => "Berhasil menambahkan peserta ke kelas $kelas->kode"
        ], 200);
    }

    public function updatePeserta($slug, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $peserta = Peserta::where('id', $request['peserta-id'])->first();
        if(!$peserta){
          return response([
              'error' => 'Peserta tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        if($request->has('status-peserta')){
            $kelas->peserta()->updateExistingPivot($peserta->id, ['aktif' => 1]);
        }else{
            $kelas->peserta()->updateExistingPivot($peserta->id, ['aktif' => 0]);
        }
        
        return response([
            'aktif' => $request->has('status-peserta'),
            'message' => "Berhasil mengubah status $peserta->nama"
        ], 200);
    }

    public function destroyPeserta($slug, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }
        $peserta = Peserta::where('id', $request['peserta-id'])->first();
        if(!$peserta){
          return response([
              'error' => 'Peserta tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $kelas->pertemuan()->whereHas('presensi', function($query) use ($peserta){
            $query->where('peserta_id', $peserta->id);
        })->delete();

        $kelas->peserta()->detach($peserta->id);

        return response([
            'redirect' => route('kelas.daftarPeserta', ['slug' => $kelas->slug]),
            'message' => "Berhasil menghapus $peserta->nama dari kelas $kelas->kode"
        ], 200);
    }
}
