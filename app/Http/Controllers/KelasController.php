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
use App\Models\Peserta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        
        return view('kelas.detail-daftar-pertemuan', [
            'kelas' => $kelas,
            'breadcrumbs' => $breadcrumbs,
            'ruanganOptions' => $ruanganOptions,
        ]);
    }

    public function store(Request $request)
    {
        
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
        $kelas = Kelas::where('slug', $slug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'kode-kelas' => 'required|unique:kelas,kode,' . $kelas->id,
            'program' => 'required|exists:program_kelas,id',
            'tipe' => 'required|exists:tipe_kelas,id',
            'nomor-kelas' => 'required|numeric',
            'level' => 'required|exists:level_kelas,id',
            'banyak-pertemuan' => 'required|numeric',
            'tanggal-mulai' => 'required|date',
            'ruangan' => 'required|exists:ruangan,id',
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
            'level.required' => 'Level tidak boleh kosong',
            'level.exists' => 'Level tidak valid',
            'banyak-pertemuan.required' => 'Banyak pertemuan tidak boleh kosong',
            'banyak-pertemuan.numeric' => 'Banyak pertemuan harus berupa angka',
            'tanggal-mulai.required' => 'Tanggal mulai tidak boleh kosong',
            'tanggal-mulai.date' => 'Tanggal mulai tidak valid',
            'ruangan.required' => 'Ruangan tidak boleh kosong',
            'ruangan.exists' => 'Ruangan tidak valid',
            'hari.required' => 'Hari tidak boleh kosong',
            'hari.array' => 'Hari tidak valid',
            'hari.*.required' => 'Hari tidak boleh kosong',
            'hari.*.numeric' => 'Hari tidak valid',
            'waktu-mulai.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.array' => 'Waktu mulai tidak valid',
            'waktu-mulai.*.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.*.date_format' => 'Waktu mulai tidak valid',
            'waktu-selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu-selesai.array' => 'Waktu selesai tidak valid',
            'waktu-selesai.*.required' => 'Waktu selesai tidak boleh kosong',
            'pengajar.required' => 'Pengajar tidak boleh kosong',
            'pengajar.array' => 'Pengajar tidak valid',
            'pengajar.*.required' => 'Pengajar tidak boleh kosong',
            'pengajar.*.exists' => 'Pengajar tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }else{
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
        }
        
        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Detail kelas berhasil diubah'
        ]);

        return response(['redirect' => route('kelas.detail', ['slug' => $kelas->slug])], 200);
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

    public function daftarPeserta($slug)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', ['slug' => $kelas->slug]),
            'Daftar Peserta' => null,
        ];

        $pesertaList = $kelas->peserta()->orderBy('nama')->paginate(20);
        
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
        $kelas = Kelas::where('slug', $slug)->firstOrFail();

        $validator = $this->validatePeserta($request, $kelas);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }else{
            for($i = 0; $i < count($request['nik-peserta']); $i++){
                $peserta = Peserta::firstOrCreate([
                    'nik' => $request['nik-peserta'][$i],
                ], [
                    'nama' => $request['nama-peserta'][$i],
                    'occupation' => $request['occupation-peserta'][$i],
                ]);

                $kelas->peserta()->attach($peserta->id);
            }
        }

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Peserta berhasil ditambahkan',
        ]);

        return response(['redirect' => route('kelas.daftarPeserta', ['slug' => $kelas->slug])], 200);
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

    private function validatePeserta($request, $kelas)
    {
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

        return $validator;
    }
}
