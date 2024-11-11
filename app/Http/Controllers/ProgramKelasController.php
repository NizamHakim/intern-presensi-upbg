<?php

namespace App\Http\Controllers;

use App\Models\ProgramKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramKelasController extends Controller
{
    public function index()
    {
        $programList = ProgramKelas::paginate(10);
        return view('kelas.program.daftar-program', [
            'programList' => $programList
        ]);
    }

    public function update(Request $request, ProgramKelas $programKelas)
    {
        $validator = Validator::make($request->all(), [
            'nama-program' => 'required|string',
            'kode-program' => 'required|string|unique:program_kelas,kode,' . $programKelas->id,
            'status-program' => 'required|boolean',
        ], [
            'nama-program.required' => 'Nama program tidak boleh kosong',
            'nama-program.string' => 'Nama program harus berupa string',
            'kode-program.required' => 'Kode program tidak boleh kosong',
            'kode-program.string' => 'Kode program harus berupa string',
            'kode-program.unique' => 'Kode program sudah digunakan',
            'status-program.required' => 'Status program tidak boleh kosong',
            'status-program.boolean' => 'Status program harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }else{
            $programKelas->update([
                'nama' => $request['nama-program'],
                'kode' => $request['kode-program'],
                'aktif' => $request['status-program'],
            ]);
        }

        return response($programKelas->only(['id', 'nama', 'kode', 'aktif']), 200);
    }

    public function destroy(Request $request)
    {
        $programKelas = ProgramKelas::findOrFail($request['program-id']);
        if($request->has('force-delete')){
            $programKelas->forceDelete();
        }else{
            $programKelas->delete();
        }
        return redirect()->route('program-kelas.index');
    }
}
