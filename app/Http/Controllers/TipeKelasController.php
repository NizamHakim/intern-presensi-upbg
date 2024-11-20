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

    public function create()
    {
        $breadcrumbs = [
            'Tipe Kelas' => route('tipe-kelas.index'),
            'Tambah Tipe' => route('tipe-kelas.create')
        ];

        return view('kelas.tipe.tambah-tipe', [
            'breadcrumbs' => $breadcrumbs
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
        ]);

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Tipe ' . $request['nama-tipe'] . ' - ' . $request['kode-tipe'] . ' berhasil ditambahkan'
        ]);

        return response(['redirect' => route('tipe-kelas.index')], 200);
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

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Tipe ' . $tipeKelas->nama . ' - ' . $tipeKelas->kode . ' berhasil dihapus'
        ]);
        
        return redirect()->route('tipe-kelas.index');
    }
}
