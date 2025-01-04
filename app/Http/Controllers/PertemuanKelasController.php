<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Ruangan;
use App\Helpers\RouteGraph;
use Illuminate\Http\Request;
use App\Models\PertemuanKelas;
use App\Models\PresensiPertemuanKelas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

        $pertemuan->load('presensi.peserta');

        $pengajarOptions = $kelas->pengajar()->get();
        $tambahPesertaOptions = $kelas->peserta()->whereNotIn('peserta.id', $pertemuan->presensi->pluck('peserta_id'))->get();
        $ruanganOptions = Ruangan::all();

        return view('kelas.pertemuan.detail-pertemuan', [
            'kelas' => $kelas,
            'pertemuan' => $pertemuan,
            'breadcrumbs' => $breadcrumbs,
            'pengajarOptions' => $pengajarOptions,
            'tambahPesertaOptions' => $tambahPesertaOptions,
            'ruanganOptions' => $ruanganOptions,
        ]);
    }

    public function store($slug, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'waktu-mulai' => 'required|date_format:H:i',
            'waktu-selesai' => 'required|date_format:H:i',
            'ruangan' => 'required|exists:ruangan,id',
        ], [
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'tanggal.date' => 'Tanggal tidak valid',
            'waktu-mulai.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.date_format' => 'Waktu mulai tidak valid',
            'waktu-selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu-selesai.date_format' => 'Waktu selesai tidak valid',
            'ruangan.required' => 'Ruangan tidak boleh kosong',
            'ruangan.exists' => 'Ruangan tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $kelas->pertemuan()->create([
            'pertemuan_ke' => $kelas->pertemuan()->count() + 1,
            'tanggal' => $request['tanggal'],
            'waktu_mulai' => $request['waktu-mulai'],
            'waktu_selesai' => $request['waktu-selesai'],
            'ruangan_id' => $request['ruangan'],
        ]);

        $this->reorder($kelas);

        return response([
            'redirect' => route('kelas.detail', $kelas->slug),
            'message' => 'Pertemuan berhasil ditambahkan'
        ], 200);
    }

    public function edit($slug, $id)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $pertemuan = $kelas->pertemuan()->findOrFail($id);

        $ruanganOptions = Ruangan::all();

        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', $kelas->slug),
            "Pertemuan - $pertemuan->pertemuan_ke" => route('kelas.pertemuan.detail', [$kelas->slug, $pertemuan->id]),
            'Edit' => null,
        ];

        return view('kelas.pertemuan.edit-pertemuan', [
            'kelas' => $kelas,
            'pertemuan' => $pertemuan,
            'breadcrumbs' => $breadcrumbs,
            'ruanganOptions' => $ruanganOptions,
        ]);
    }

    public function updateDetail($slug, $id, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }
        $pertemuan = $kelas->pertemuan()->find($id);
        if(!$pertemuan){
          return response([
              'error' => 'Pertemuan tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $validator = Validator::make($request->all(), [
            'terlaksana' => 'required|boolean',
            'pengajar-id' => 'nullable|exists:pengajar_kelas,user_id',
            'tanggal' => 'required|date',
            'waktu-mulai' => 'required|date_format:H:i',
            'waktu-selesai' => 'required|date_format:H:i',
            'ruangan' => 'required|exists:ruangan,id',
        ], [
            'terlaksana.required' => 'Status pertemuan tidak boleh kosong',
            'terlaksana.boolean' => 'Status pertemuan tidak valid',
            'pengajar-id.exists' => 'Pengajar tidak valid',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'tanggal.date' => 'Tanggal tidak valid',
            'waktu-mulai.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.date_format' => 'Waktu mulai tidak valid',
            'waktu-selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu-selesai.date_format' => 'Waktu selesai tidak valid',
            'ruangan.required' => 'Ruangan tidak boleh kosong',
            'ruangan.exists' => 'Ruangan tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        if($request['terlaksana'] == 1 && $pertemuan->presensi->isEmpty()){
            $this->generatePresensi($kelas, $pertemuan);
        }else if($request['terlaksana'] == 0){
            $pertemuan->presensi()->delete();
        }

        $pertemuan->update([
            'terlaksana' => $request['terlaksana'],
            'pengajar_id' => $request['pengajar-id'],
            'tanggal' => $request['tanggal'],
            'waktu_mulai' => $request['waktu-mulai'],
            'waktu_selesai' => $request['waktu-selesai'],
            'ruangan_id' => $request['ruangan'],
        ]);

        $this->reorder($kelas);

        return response([
            'redirect' => route('kelas.pertemuan.detail', [$kelas->slug, $pertemuan->id]),
            'message' => 'Pertemuan berhasil diupdate'
        ], 200);
    }

    public function updateTopikCatatan($slug, $id, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }
        $pertemuan = $kelas->pertemuan()->find($id);
        if(!$pertemuan){
          return response([
              'error' => 'Pertemuan tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $validator = Validator::make($request->all(), [
            'topik' => 'nullable|string',
            'catatan' => 'nullable|string',
        ], [
            'topik.string' => 'Topik tidak valid',
            'catatan.string' => 'Catatan tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $pertemuan->update([
            'topik' => $request['topik'],
            'catatan' => $request['catatan'],
        ]);

        return response([
            'message' => 'Topik dan catatan berhasil diupdate',
            'topik' => $pertemuan->topik,
            'catatan' => $pertemuan->catatan,
        ], 200);
    }

    public function reschedule($slug, $id, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }
        $pertemuan = $kelas->pertemuan()->find($id);
        if(!$pertemuan){
          return response([
              'error' => 'Pertemuan tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'waktu-mulai' => 'required|date_format:H:i',
            'waktu-selesai' => 'required|date_format:H:i',
            'ruangan' => 'required|exists:ruangan,id',
        ], [
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'tanggal.date' => 'Tanggal tidak valid',
            'waktu-mulai.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.date_format' => 'Waktu mulai tidak valid',
            'waktu-selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu-selesai.date_format' => 'Waktu selesai tidak valid',
            'ruangan.required' => 'Ruangan tidak boleh kosong',
            'ruangan.exists' => 'Ruangan tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $pertemuan->update([
            'tanggal' => $request['tanggal'],
            'waktu_mulai' => $request['waktu-mulai'],
            'waktu_selesai' => $request['waktu-selesai'],
            'ruangan_id' => $request['ruangan'],
        ]);

        $this->reorder($kelas);

        return response([
            'redirect' => route('kelas.pertemuan.detail', [$kelas->slug, $pertemuan->id]),
            'message' => 'Pertemuan berhasil diupdate'
        ], 200);
    }

    public function mulaiPertemuan($slug, $id, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }
        $pertemuan = $kelas->pertemuan()->find($id);
        if(!$pertemuan){
          return response([
              'error' => 'Pertemuan tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $validator = Validator::make($request->all(), [
            'pengajar-id' => 'required|exists:pengajar_kelas,user_id',
        ], [
            'pengajar-id.required' => 'Pengajar tidak boleh kosong',
            'pengajar-id.exists' => 'Pengajar tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $pertemuan->update([
            'terlaksana' => 1,
            'pengajar_id' => $request['pengajar-id'],
        ]);
            
        $this->generatePresensi($kelas, $pertemuan);

        return response([
            'redirect' => route('kelas.pertemuan.detail', [$kelas->slug, $pertemuan->id]),
            'message' => 'Pertemuan berhasil dimulai'
        ], 200);
    }

    public function destroy($slug, $id)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if(!$kelas){
          return response([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }
        $pertemuan = $kelas->pertemuan()->find($id);
        if(!$pertemuan){
          return response([
              'error' => 'Pertemuan tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }
        
        $pertemuan->delete();

        $this->reorder($kelas);
   
        return response([
            'redirect' => route('kelas.detail', $kelas->slug),
            'message' => 'Pertemuan berhasil dihapus'
        ], 200);
    }

    private function reorder($kelas)
    {
        $pertemuan = $kelas->pertemuan()->get();
        $pertemuan->each(function($pertemuan, $index) {
            $pertemuan->update(['pertemuan_ke' => $index + 1]);
        });
    }

    private function generatePresensi($kelas, $pertemuan)
    {
        $peserta = $kelas->peserta()->wherePivot('aktif', 1)->get();

        $pertemuan->presensi()->createMany(
            $peserta->map(function($peserta) {
                return ['peserta_id' => $peserta->id];
            })->toArray()
        );
    }
}
