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

    public function create()
    {
        $breadcrumbs = [
            'Level Kelas' => route('level-kelas.index'),
            'Tambah Level' => route('level-kelas.create')
        ];

        return view('kelas.level.tambah-level', [
            'breadcrumbs' => $breadcrumbs
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
        ]);

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Level ' . $request['nama-level'] . ' - ' . $request['kode-level'] . ' berhasil ditambahkan'
        ]);

        return response(['redirect' => route('level-kelas.index')], 200);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama-level' => 'required|string',
            'kode-level' => 'nullable|string|unique:level_kelas,kode,' . $id,
            'status-level' => 'required|boolean',
        ], [
            'nama-level.required' => 'Nama level tidak boleh kosong',
            'nama-level.string' => 'Nama level harus berupa string',
            'kode-level.required' => 'Kode level tidak boleh kosong',
            'kode-level.string' => 'Kode level harus berupa string',
            'kode-level.unique' => 'Kode level sudah digunakan',
            'status-level.required' => 'Status level tidak boleh kosong',
            'status-level.boolean' => 'Status level harus berupa boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }else{
            try{
                $levelKelas = LevelKelas::findOrFail($id);
                $levelKelas->update([
                    'nama' => $request['nama-level'],
                    'kode' => $request['kode-level'],
                    'aktif' => $request['status-level'],
                ]);
            }catch(ModelNotFoundException $e){
                return response('Level kelas tidak ditemukan', 404);
            }
        }

        return response($levelKelas->only(['id', 'nama', 'kode', 'aktif']), 200);
    }

    public function destroy(Request $request)
    {
        $levelKelas = LevelKelas::findOrFail($request['level-id']);
        if($request->has('force-delete')){
            $levelKelas->forceDelete();
        }else{
            $levelKelas->delete();
        }

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Level ' . $levelKelas->nama . ' - ' . $levelKelas->kode . ' berhasil dihapus'
        ]);
        
        return redirect()->route('level-kelas.index');
    }
}
