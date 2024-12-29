<?php

namespace App\Http\Controllers;

use App\Models\LevelKelas;
use App\Helpers\RouteGraph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LevelKelasController extends Controller
{
    public function index()
    {
        $levelList = LevelKelas::paginate(10);
        return view('kelas.level.daftar-level', [
            'levelList' => $levelList
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama-level' => 'required|string',
            'kode-level' => 'nullable|string|unique:level_kelas,kode',
        ], [
            'nama-level.required' => 'Nama level tidak boleh kosong',
            'nama-level.string' => 'Nama level harus berupa string',
            'kode-level.string' => 'Kode level harus berupa string',
            'kode-level.unique' => 'Kode level sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        LevelKelas::create([
            'nama' => $request['nama-level'],
            'kode' => $request['kode-level'],
            'aktif' => $request->has('status-level') ? true : false,
        ]);

        return response([
            'message' => 'Level ' . $request['nama-level'] . ' - ' . $request['kode-level'] . ' berhasil ditambahkan',
            'redirect' => route('level-kelas.index')
        ], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama-level' => 'required|string',
            'kode-level' => 'nullable|string|unique:level_kelas,kode,' . $request['level-id'],
        ], [
            'nama-level.required' => 'Nama level tidak boleh kosong',
            'nama-level.string' => 'Nama level harus berupa string',
            'kode-level.required' => 'Kode level tidak boleh kosong',
            'kode-level.string' => 'Kode level harus berupa string',
            'kode-level.unique' => 'Kode level sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $levelKelas = LevelKelas::findOrFail($request['level-id']);
        $levelKelas->update([
            'nama' => $request['nama-level'],
            'kode' => $request['kode-level'],
            'aktif' => $request->has('status-level') ? true : false,
        ]);
        return response($levelKelas->only(['nama', 'kode', 'aktif']), 200);
    }

    public function destroy(Request $request)
    {
        $levelKelas = LevelKelas::findOrFail($request['level-id']);
        if($request->has('force-delete')){
            $levelKelas->forceDelete();
        }else{
            $levelKelas->delete();
        }

        return response([
            'message' => 'Level ' . $levelKelas->nama . ' - ' . $levelKelas->kode . ' berhasil dihapus',
            'redirect' => route('level-kelas.index')
        ], 200);
    }

    public function restore(Request $request)
    {
        $levelKelas = LevelKelas::withTrashed()->findOrFail($request['level-id']);
        $levelKelas->restore();

        return response([
            'message' => 'Level ' . $levelKelas->nama . ' - ' . $levelKelas->kode . ' berhasil direstore',
            'redirect' => route('level-kelas.index')
        ], 200);
    }
}
