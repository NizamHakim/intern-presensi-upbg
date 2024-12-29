<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    public function index()
    {
        $ruanganList = Ruangan::paginate(10);
        return view('ruangan.daftar-ruangan', [
            'ruanganList' => $ruanganList
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode-ruangan' => 'required|string|unique:ruangan,kode',
            'kapasitas-ruangan' => 'required|numeric',
        ], [
            'kode-ruangan.required' => 'Kode ruangan tidak boleh kosong',
            'kode-ruangan.string' => 'Kode ruangan harus berupa string',
            'kode-ruangan.unique' => 'Kode ruangan sudah digunakan',
            'kapasitas-ruangan.required' => 'Kapasitas ruangan tidak boleh kosong',
            'kapasitas-ruangan.numeric' => 'Kapasitas ruangan harus berupa angka',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        Ruangan::create([
            'kode' => $request['kode-ruangan'],
            'kapasitas' => $request['kapasitas-ruangan'],
            'status' => $request->has('status-ruangan') ? true : false,
        ]);

        return response([
            'message' => 'Ruangan ' . $request['kode-ruangan'] . ' berhasil ditambahkan',
            'redirect' => route('ruangan.index')
        ], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode-ruangan' => 'required|string|unique:ruangan,kode,' . $request['ruangan-id'],
            'kapasitas-ruangan' => 'required|numeric',
        ], [
            'kode-ruangan.required' => 'Kode ruangan tidak boleh kosong',
            'kode-ruangan.string' => 'Kode ruangan harus berupa string',
            'kode-ruangan.unique' => 'Kode ruangan sudah digunakan',
            'kapasitas-ruangan.required' => 'Kapasitas ruangan tidak boleh kosong',
            'kapasitas-ruangan.numeric' => 'Kapasitas ruangan harus berupa angka',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $ruangan = Ruangan::findOrFail($request['ruangan-id']);
        $ruangan->update([
            'kode' => $request['kode-ruangan'],
            'kapasitas' => $request['kapasitas-ruangan'],
            'status' => $request->has('status-ruangan') ? true : false,
        ]);

        return response($ruangan->only(['kode', 'kapasitas', 'status']), 200);
    }

    public function destroy(Request $request)
    {
        $ruangan = Ruangan::findOrFail($request['ruangan-id']);
        if($request->has('force-delete')){
            $ruangan->forceDelete();
        }else{
            $ruangan->delete();
        }

        return response([
          'message' => 'Ruangan ' . $ruangan->kode . ' berhasil dihapus',
          'redirect' => route('ruangan.index')
        ], 200);
    }

    public function restore(Request $request)
    {
        $ruangan = Ruangan::withTrashed()->findOrFail($request['ruangan-id']);
        $ruangan->restore();

        return response([
          'message' => 'Ruangan ' . $ruangan->kode . ' berhasil direstore',
          'redirect' => route('ruangan.index')
        ], 200);
    }
}
