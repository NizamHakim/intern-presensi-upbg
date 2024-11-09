<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $searchOptions = collect([
            ['text' => 'Nama', 'value' => 'nama'],
            ['text' => 'NIK / NRP', 'value' => 'nik-nrp'],
            ['text' => 'Occupation', 'value' => 'occupation'],
        ]);

        $pesertaList = Peserta::query();

        if($request->query('nama')){
            $arraySearch = explode(' ', $request->query('nama'));
            foreach($arraySearch as $search){
                $pesertaList->where('nama', 'like', '%'.$search.'%');
            }
            $searchSelected = $searchOptions->where('value', 'nama')->first();
            $searchValue = $request->query('nama');
        }elseif($request->query('nik-nrp')){
            $pesertaList->where('nik', 'like', '%'.$request->query('nik-nrp').'%');
            $searchSelected = $searchOptions->where('value', 'nik-nrp')->first();
            $searchValue = $request->query('nik-nrp');
        }elseif($request->query('occupation')){
            $pesertaList->where('occupation', 'like', '%'.$request->query('occupation').'%');
            $searchSelected = $searchOptions->where('value', 'occupation')->first();
            $searchValue = $request->query('occupation');
        }else{
            $searchSelected = $searchOptions->first();
            $searchValue = '';
        }

        $pesertaList = $pesertaList->paginate(10)->appends($request->query());

        return view('peserta.daftar-peserta', [
            'pesertaList' => $pesertaList,
            'searchOptions' => $searchOptions,
            'searchSelected' => $searchSelected,
            'searchValue' => $searchValue,
        ]);
    }
}
