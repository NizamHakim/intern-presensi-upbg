<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiPertemuanKelas;
use Illuminate\Support\Facades\Validator;

class PresensiPertemuanKelasController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pertemuan-id' => 'required|exists:pertemuan_kelas,id',
            'peserta-id' => 'required|exists:peserta,id',
        ], [
            'pertemuan-id.required' => 'Pertemuan tidak boleh kosong',
            'pertemuan-id.exists' => 'Pertemuan tidak valid',
            'peserta-id.required' => 'Peserta tidak boleh kosong',
            'peserta-id.exists' => 'Peserta tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $presensi = PresensiPertemuanKelas::create([
            'pertemuan_id' => $request['pertemuan-id'],
            'peserta_id' => $request['peserta-id'],
        ]);

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Presensi berhasil ditambahkan'
        ]);

        return response([
            'redirect' => route('kelas.pertemuan.detail', [$presensi->pertemuan->kelas->slug, $presensi->pertemuan->id]),
        ]);
    }

    public function updatePresensi($id, Request $request){

        $validator = Validator::make($request->all(), [
            'hadir' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $presensi = PresensiPertemuanKelas::findOrFail($id);
        $presensi->update([
            'hadir' => $request->hadir,
        ]);

        return response([
            'hadir' => PresensiPertemuanKelas::where('pertemuan_id', $presensi->pertemuan_id)->where('hadir', true)->count(),
            'total' => PresensiPertemuanKelas::where('pertemuan_id', $presensi->pertemuan_id)->count(),
        ], 200);
    }

    public function updatePresensiAll($pertemuanId){
        $presensi = PresensiPertemuanKelas::where('pertemuan_id', $pertemuanId)->get();
        $presensi->each->update([
            'hadir' => true,
        ]);

        return response([
            'hadir' => PresensiPertemuanKelas::where('pertemuan_id', $pertemuanId)->where('hadir', true)->count(),
            'total' => PresensiPertemuanKelas::where('pertemuan_id', $pertemuanId)->count(),
        ], 200);
    }

    public function destroy(Request $request){
        $presensi = PresensiPertemuanKelas::findOrFail($request->id);
        $presensi->delete();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Presensi berhasil dihapus'
        ]);

        return redirect()->route('kelas.pertemuan.detail', [$presensi->pertemuan->kelas->slug, $presensi->pertemuan->id]);
    }
}
