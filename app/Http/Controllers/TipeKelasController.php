<?php

namespace App\Http\Controllers;

use App\Models\TipeKelas;
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

    public function create()
    {
        return view('kelas.tipe.tambah-tipe');
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama-tipe' => 'required|string',
            'kode-tipe' => 'required|string|unique:tipe_kelas,kode,' . $id,
            'status-tipe' => 'required|boolean',
        ], [
            'nama-tipe.required' => 'Nama tipe tidak boleh kosong',
            'nama-tipe.string' => 'Nama tipe harus berupa string',
            'kode-tipe.required' => 'Kode tipe tidak boleh kosong',
            'kode-tipe.string' => 'Kode tipe harus berupa string',
            'kode-tipe.unique' => 'Kode tipe sudah digunakan',
            'status-tipe.required' => 'Status tipe tidak boleh kosong',
            'status-tipe.boolean' => 'Status tipe harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }else{
            try{
                $tipeKelas = TipeKelas::findOrFail($id);
                $tipeKelas->update([
                    'nama' => $request['nama-tipe'],
                    'kode' => $request['kode-tipe'],
                    'aktif' => $request['status-tipe'],
                ]);
            }catch(ModelNotFoundException $e){
                return response('Tipe kelas tidak ditemukan', 404);
            }
        }

        return response($tipeKelas->only(['id', 'nama', 'kode', 'aktif']), 200);
    }

    public function destroy(Request $request)
    {
        $tipeKelas = TipeKelas::findOrFail($request['tipe-id']);
        if($request->has('force-delete')){
            $tipeKelas->forceDelete();
        }else{
            $tipeKelas->delete();
        }
        return redirect()->route('tipe-kelas.index');
    }
}
