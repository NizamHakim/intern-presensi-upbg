<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\PertemuanKelas;
use Illuminate\Http\Request;
use App\Models\PresensiPertemuanKelas;
use Illuminate\Support\Facades\Validator;

class PresensiPertemuanKelasController extends Controller
{
    public function store($slug, $id, Request $request)
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
            'peserta-id' => 'required|exists:peserta,id',
            'hadir' => 'required|boolean',
        ], [
            'peserta-id.required' => 'Peserta tidak boleh kosong',
            'peserta-id.exists' => 'Peserta tidak valid',
            'hadir.required' => 'Status kehadiran tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $pertemuan->presensi()->create([
            'peserta_id' => $request['peserta-id'],
            'hadir' => $request['hadir'],
        ]);

        return response([
            'redirect' => route('kelas.pertemuan.detail', ['slug' => $slug, 'id' => $id]),
            'message' => 'Presensi berhasil ditambahkan'
        ]);
    }

    public function updatePresensi($slug, $id, $presensiId, Request $request){
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
        $presensi = $pertemuan->presensi()->find($presensiId);
        if(!$presensi){
          return response([
              'error' => 'Presensi tidak ditemukan, silahkan refresh dan coba lagi'
          ], 404);
        }

        $validator = Validator::make($request->all(), [
            'hadir' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $presensi->update([
            'hadir' => $request->hadir,
        ]);

        return response([
            'hadir' => PresensiPertemuanKelas::where('pertemuan_id', $presensi->pertemuan_id)->where('hadir', true)->count(),
            'total' => PresensiPertemuanKelas::where('pertemuan_id', $presensi->pertemuan_id)->count(),
        ], 200);
    }

    public function updatePresensiAll($slug, $id){
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

        $pertemuan->presensi()->update([
            'hadir' => true,
        ]);

        return response([
            'hadir' => PresensiPertemuanKelas::where('pertemuan_id', $pertemuan->id)->where('hadir', true)->count(),
            'total' => PresensiPertemuanKelas::where('pertemuan_id', $pertemuan->id)->count(),
        ], 200);
    }

    public function destroy($slug, $id, Request $request){
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
      $presensi = $pertemuan->presensi()->find($request['presensi-id']);
      if(!$presensi){
        return response([
            'error' => 'Presensi tidak ditemukan, silahkan refresh dan coba lagi'
        ], 404);
      }
      
      $presensi->delete();

      return response([
          'redirect' => route('kelas.pertemuan.detail', ['slug' => $slug, 'id' => $id]),
          'message' => 'Presensi berhasil dihapus'
      ], 200);
    }
}
