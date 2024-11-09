<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $usersList = User::query();

        $roleOptions = Role::all()->map->only(['text', 'value'])->prepend(['text' => 'Semua', 'value' => null]);
        $roleSelected = ($request->query('role') != null) ? Role::findOrFail($request->query('role')) : null;

        $usersList->when($roleSelected != null, function($query) use ($roleSelected){
            return $query->whereHas('roles', function($query) use ($roleSelected){
                $query->where('role_id', $roleSelected->id);
            });
        });

        $searchOptions = collect([
            ['text' => 'Nama', 'value' => 'nama'],
            ['text' => 'NIK / NIP', 'value' => 'nik-nip'],
        ]);

        if($request->query('nama')){
            $arraySearch = explode(' ', $request->query('nama'));
            foreach($arraySearch as $search){
                $usersList->where('nama', 'like', '%'.$search.'%');
            }
            $searchSelected = $searchOptions->where('value', 'nama')->first();
            $searchValue = $request->query('nama');
        }elseif($request->query('nik-nip')){
            $usersList->where('nik', 'like', '%'.$request->query('nik-nip').'%');
            $searchSelected = $searchOptions->where('value', 'nik-nip')->first();
            $searchValue = $request->query('nik-nip');
        }else{
            $searchSelected = $searchOptions->first();
            $searchValue = '';
        }

        $usersList = $usersList->paginate(10)->appends($request->query());

        return view('user.daftar-user', [
            'roleOptions' => $roleOptions,
            'roleSelected' => $roleSelected ? $roleSelected->only(['text', 'value']) : $roleOptions[0],
            'searchOptions' => $searchOptions,
            'searchSelected' => $searchSelected,
            'searchValue' => $searchValue,
            'usersList' => $usersList,
        ]);
    }
}
