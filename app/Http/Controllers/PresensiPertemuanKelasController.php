<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\PresensiPertemuanKelas;
use Illuminate\Support\Facades\Validator;

class PresensiPertemuanKelasController extends Controller
{
    public function store($slug, $id, Request $request)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $pertemuan = $kelas->pertemuan()->findOrFail($id);

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
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $pertemuan = $kelas->pertemuan()->findOrFail($id);
        $presensi = $pertemuan->presensi()->findOrFail($presensiId);

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
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $pertemuan = $kelas->pertemuan()->findOrFail($id);
        $pertemuan->presensi()->update([
            'hadir' => true,
        ]);

        return response([
            'hadir' => PresensiPertemuanKelas::where('pertemuan_id', $pertemuan->id)->where('hadir', true)->count(),
            'total' => PresensiPertemuanKelas::where('pertemuan_id', $pertemuan->id)->count(),
        ], 200);
    }

    public function destroy(Request $request){
        $presensi = PresensiPertemuanKelas::findOrFail($request['presensi-id']);
        $pertemuan = $presensi->pertemuan;
        $presensi->delete();

        return response([
            'redirect' => route('kelas.pertemuan.detail', [$pertemuan->kelas->slug, $pertemuan->id]),
            'message' => 'Presensi berhasil dihapus'
        ], 200);
    }
}
