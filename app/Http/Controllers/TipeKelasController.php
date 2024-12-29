<?php

namespace App\Http\Controllers;

use App\Models\TipeKelas;
use App\Helpers\RouteGraph;
use App\Models\Scopes\Aktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TipeKelasController extends Controller
{
    public function index()
    {
        $tipeList = TipeKelas::paginate(10);
        return view('kelas.tipe.daftar-tipe', [
            'tipeList' => $tipeList
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama-tipe' => 'required|string',
            'kode-tipe' => 'required|string|unique:tipe_kelas,kode',
        ], [
            'nama-tipe.required' => 'Nama tipe tidak boleh kosong',
            'nama-tipe.string' => 'Nama tipe harus berupa string',
            'kode-tipe.required' => 'Kode tipe tidak boleh kosong',
            'kode-tipe.string' => 'Kode tipe harus berupa string',
            'kode-tipe.unique' => 'Kode tipe sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        TipeKelas::create([
            'nama' => $request['nama-tipe'],
            'kode' => $request['kode-tipe'],
            'aktif' => $request->has('status-tipe') ? true : false,
        ]);

        return response([
            'message' => 'Tipe ' . $request['nama-tipe'] . ' - ' . $request['kode-tipe'] . ' berhasil ditambahkan',
            'redirect' => route('tipe-kelas.index')
        ], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama-tipe' => 'required|string',
            'kode-tipe' => 'required|string|unique:tipe_kelas,kode,' . $request['tipe-id'],
        ], [
            'nama-tipe.required' => 'Nama tipe tidak boleh kosong',
            'nama-tipe.string' => 'Nama tipe harus berupa string',
            'kode-tipe.required' => 'Kode tipe tidak boleh kosong',
            'kode-tipe.string' => 'Kode tipe harus berupa string',
            'kode-tipe.unique' => 'Kode tipe sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $tipeKelas = TipeKelas::findOrFail($request['tipe-id']);
        $tipeKelas->update([
            'nama' => $request['nama-tipe'],
            'kode' => $request['kode-tipe'],
            'aktif' => $request->has('status-tipe') ? true : false,
        ]);

        return response($tipeKelas->only(['nama', 'kode', 'aktif']), 200);
    }

    public function destroy(Request $request)
    {
        $tipeKelas = TipeKelas::findOrFail($request['tipe-id']);
        if($request->has('force-delete')){
            $tipeKelas->forceDelete();
        }else{
            $tipeKelas->delete();
        }

        return response([
            'message' => 'Tipe ' . $tipeKelas->nama . ' - ' . $tipeKelas->kode . ' berhasil dihapus',
            'redirect' => route('tipe-kelas.index')
        ], 200);
    }

    public function restore(Request $request)
    {
        TipeKelas::onlyTrashed()->findOrFail($request['tipe-id'])->restore();
        return response([
            'message' => 'Tipe berhasil dipulihkan',
            'redirect' => route('tipe-kelas.index')
        ], 200);
    }
}
