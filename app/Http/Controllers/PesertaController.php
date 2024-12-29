<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
      $pesertaList = Peserta::query();

      $categoricalSearchOptions = collect([
        ['text' => 'Nama', 'name' => 'nama', 'placeholder' => 'Cari nama peserta'],
        ['text' => 'NIK / NRP', 'name' => 'nik', 'placeholder' => 'Cari NIK atau NRP peserta'],
        ['text' => 'Occupation', 'name' => 'occupation', 'placeholder' => 'Cari Dept. / Occupation peserta'],
      ]);

      $selected = [];

      $pesertaList->when($request->query('nama'), function($query) use ($request, $categoricalSearchOptions, &$selected){
        $selected['categorical'] = $categoricalSearchOptions->where('name', 'nama')->first();
        $selected['search'] = $request->query('nama');
        return $query->where('nama', 'like', '%'.$request->query('nama').'%');
      });

      $pesertaList->when($request->query('nik'), function($query) use ($request, $categoricalSearchOptions, &$selected){
        $selected['categorical'] = $categoricalSearchOptions->where('name', 'nik')->first();
        $selected['search'] = $request->query('nik');
        return $query->where('nik', 'like', '%'.$request->query('nik').'%');
      });

      $pesertaList->when($request->query('occupation'), function($query) use ($request, $categoricalSearchOptions, &$selected){
        $selected['categorical'] = $categoricalSearchOptions->where('name', 'occupation')->first();
        $selected['search'] = $request->query('occupation');
        return $query->where('occupation', 'like', '%'.$request->query('occupation').'%');
      });

      if(!isset($selected['categorical'])){
        $selected['categorical'] = $categoricalSearchOptions->first();
      }

      $pesertaList = $pesertaList->paginate(10)->appends($request->all());

      return view('peserta.daftar-peserta', [
          'pesertaList' => $pesertaList,
          'categoricalSearchOptions' => $categoricalSearchOptions,
          'selected' => $selected,
      ]);
    }

    public function detail($id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->load('kelas', 'tes');

        $breadcrumbs = [
            'Peserta' => route('peserta.index'),
            $peserta->nama => route('peserta.detail', $peserta->id),
        ];

        return view('peserta.detail-peserta', [
            'peserta' => $peserta,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [
          'nik' => 'required|string|unique:peserta,nik,' . $id,
          'nama' => 'required|string',
          'occupation' => 'required|string',
      ], [
          'nik.required' => 'NIK / NRP tidak boleh kosong',
          'nik.string' => 'NIK / NRP harus berupa string',
          'nik.unique' => 'NIK / NRP sudah digunakan',
          'nama.required' => 'Nama tidak boleh kosong',
          'nama.string' => 'Nama harus berupa string',
          'occupation.required' => 'Dept. / Occupation tidak boleh kosong',
          'occupation.string' => 'Dept. / Occupation harus berupa string',
      ]);
      
      if ($validator->fails()) {
        return response($validator->errors(), 422);
      }

      $peserta = Peserta::findOrFail($id);
      $peserta->update([
          'nik' => $request['nik'],
          'nama' => $request['nama'],
          'occupation' => $request['occupation'],
      ]);

      return response([
          'message' => 'Peserta ' . $request['nama'] . ' - ' . $request['nik'] . ' berhasil diupdate',
          'updatedPeserta' => $peserta->only(['nik', 'nama', 'occupation']),
      ], 200);
    }

    public function destroy($id)
    {
      $peserta = Peserta::findOrFail($id);
      $peserta->delete();

      return response([
          'message' => 'Peserta ' . $peserta->nama . ' - ' . $peserta->nik . ' berhasil dihapus',
          'redirect' => route('peserta.index'),
      ], 200);
    }
}
