<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiPertemuanKelas;
use Illuminate\Support\Facades\Validator;

class PresensiPertemuanKelasController extends Controller
{
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

        return response('success', 200);
    }

    public function updatePresensiAll($pertemuanId){
        $presensi = PresensiPertemuanKelas::where('pertemuan_id', $pertemuanId)->get();
        $presensi->each->update([
            'hadir' => true,
        ]);

        return response('success', 200);
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
