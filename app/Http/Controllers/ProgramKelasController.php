<?php

namespace App\Http\Controllers;

use App\Helpers\RouteGraph;
use App\Models\ProgramKelas;
use App\Models\Scopes\Aktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProgramKelasController extends Controller
{
    public function index()
    {
        $programList = ProgramKelas::paginate(10);
        return view('kelas.program.daftar-program', [
            'programList' => $programList
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama-program' => 'required|string',
            'kode-program' => 'required|string|unique:program_kelas,kode',
        ], [
            'nama-program.required' => 'Nama program tidak boleh kosong',
            'nama-program.string' => 'Nama program harus berupa string',
            'kode-program.required' => 'Kode program tidak boleh kosong',
            'kode-program.string' => 'Kode program harus berupa string',
            'kode-program.unique' => 'Kode program sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        ProgramKelas::create([
            'nama' => $request['nama-program'],
            'kode' => $request['kode-program'],
            'aktif' => $request->has('status-program') ? true : false,
        ]);

        return response([
            'message' => 'Program ' . $request['nama-program'] . ' - ' . $request['kode-program'] . ' berhasil ditambahkan',
            'redirect' => route('program-kelas.index')
        ], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama-program' => 'required|string',
            'kode-program' => 'required|string|unique:program_kelas,kode,' . $request['program-id'],
        ], [
            'nama-program.required' => 'Nama program tidak boleh kosong',
            'nama-program.string' => 'Nama program harus berupa string',
            'kode-program.required' => 'Kode program tidak boleh kosong',
            'kode-program.string' => 'Kode program harus berupa string',
            'kode-program.unique' => 'Kode program sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $programKelas = ProgramKelas::findOrFail($request['program-id']);
        $programKelas->update([
            'nama' => $request['nama-program'],
            'kode' => $request['kode-program'],
            'aktif' => $request->has('status-program') ? true : false,
        ]);

        return response($programKelas->only(['nama', 'kode', 'aktif']), 200);
    }

    public function destroy(Request $request)
    {
        $programKelas = ProgramKelas::findOrFail($request['program-id']);
        if($request->has('force-delete')){
            $programKelas->forceDelete();
        }else{
            $programKelas->delete();
        }

        return response([
          'message' => 'Program ' . $programKelas->nama . ' - ' . $programKelas->kode . ' berhasil dihapus',
          'redirect' => route('program-kelas.index')
        ], 200);
    }

    public function restore(Request $request)
    {
        $programKelas = ProgramKelas::withTrashed()->findOrFail($request['program-id']);
        $programKelas->restore();

        return response([
          'message' => 'Program ' . $programKelas->nama . ' - ' . $programKelas->kode . ' berhasil direstore',
          'redirect' => route('program-kelas.index')
        ], 200);
    }
}
