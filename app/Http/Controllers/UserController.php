<?php

namespace App\Http\Controllers;

use App\Helpers\RouteGraph;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    { 
        $usersList = User::query();

        $categoricalSearchOptions = collect([
          ['text' => 'Nama', 'name' => 'nama', 'placeholder' => 'Cari nama user'],
          ['text' => 'NIK / NIP', 'name' => 'nik', 'placeholder' => 'Cari NIK atau NIP user']
        ]);

        $selected = [];

        $usersList->when($request->query('nama'), function($query) use ($request, $categoricalSearchOptions, &$selected){
          $selected['categorical'] = $categoricalSearchOptions->where('name', 'nama')->first();
          $selected['search'] = $request->query('nama');
          return $query->where('nama', 'like', '%'.$request->query('nama').'%');
        });

        $usersList->when($request->query('nik'), function($query) use ($request, $categoricalSearchOptions, &$selected){
          $selected['categorical'] = $categoricalSearchOptions->where('name', 'nik')->first();
          $selected['search'] = $request->query('nik');
          return $query->where('nik', 'like', '%'.$request->query('nik').'%');
        });

        if(!isset($selected['categorical'])){
          $selected['categorical'] = $categoricalSearchOptions->first();
        }

        $usersList = $usersList->paginate(10)->appends($request->all());

        return view('user.daftar-user', [
            'usersList' => $usersList,
            'categoricalSearchOptions' => $categoricalSearchOptions,
            'selected' => $selected,
        ]);
    }

    public function create()
    {
        $roleOptions = Role::where('id', 2)->orWhere('id', 3)->get();
        $breadcrumbs = [
            'User' => route('user.index'),
            'Tambah User' => route('user.create')
        ];

        return view('user.tambah-user', [
            'roleOptions' => $roleOptions,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|unique:users,nik',
            'nama' => 'required|string',
            'nama-panggilan' => 'required|string',
            'no-hp' => 'nullable|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'konfirmasi-password' => 'required|same:password',
            'role' => 'nullable|array',
            'role.*' => 'exists:roles,id',
            'foto-user' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nik.required' => 'NIK / NIP tidak boleh kosong',
            'nik.numeric' => 'NIK / NIP harus berupa angka',
            'nik.unique' => 'NIK / NIP sudah terdaftar',
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.string' => 'Nama harus berupa string',
            'nama-panggilan.required' => 'Nama panggilan tidak boleh kosong',
            'nama-panggilan.string' => 'Nama panggilan harus berupa string',
            'no-hp.numeric' => 'Nomor HP harus berupa angka',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.string' => 'Password harus berupa string',
            'password.min' => 'Password minimal 8 karakter',
            'konfirmasi-password.required' => 'Konfirmasi password tidak boleh kosong',
            'konfirmasi-password.same' => 'Konfirmasi password tidak sama dengan password',
            'role.*.exists' => 'Role tidak valid',
            'foto-user.image' => 'Foto harus berupa gambar',
            'foto-user.mimes' => 'Foto harus berformat jpeg, jpg, atau png',
            'foto-user.max' => 'Foto maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $user = User::create([
            'nik' => $request['nik'],
            'nama' => $request['nama'],
            'nama_panggilan' => $request['nama-panggilan'],
            'no_hp' => $request->has('no-hp') ? $request['no-hp'] : null,
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        if($request->has('role')){
            $user->roles()->attach($request['role']);
            $user->current_role_id = $request['role'][0];
        }

        if($request->hasFile('foto-user')){
            $filename =  $request->file('foto-user')->storeAs(
                'images/profile_pictures', 
                $user->id.'.'.$request->file('foto-user')->getClientOriginalExtension(),
                'public'
            );
            $user->profile_picture = $filename;
        }

        $user->save();

        return response([
          'message' => 'User ' . $user->nama . ' berhasil ditambahkan',
          'redirect' => route('user.index'),
        ], 201);
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);
        $user->load('mengajarKelas', 'mengawasiTes', 'roles');

        if(Auth::user()->current_role_id == 2){
          $roleOptions = Role::where('id', 2)->orWhere('id', 3)->get();
        }else if(Auth::user()->current_role_id == 4){
          $roleOptions = Role::where('id', 4)->orWhere('id', 5)->get();
        }
        
        $breadcrumbs = [
            'User' => route('user.index'),
            $user->nama => route('user.detail', $user->id)
        ];

        return view('user.detail-user', [
            'user' => $user,
            'roleOptions' => $roleOptions,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'role' => 'nullable|array',
            'role.*' => 'exists:roles,id',
        ], [
            'role.*.exists' => 'Role tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }
        
        if(Auth::user()->current_role_id == 1){
          $user->roles()->sync($request['role']);
        }else if(Auth::user()->current_role_id == 2){
          in_array(2, $request['role']) ? $user->roles()->syncWithoutDetaching(2) : $user->roles()->detach(2);
          in_array(3, $request['role']) ? $user->roles()->syncWithoutDetaching(3) : $user->roles()->detach(3);
        }else if(Auth::user()->current_role_id == 4){
          in_array(4, $request['role']) ? $user->roles()->syncWithoutDetaching(4) : $user->roles()->detach(4);
          in_array(5, $request['role']) ? $user->roles()->syncWithoutDetaching(5) : $user->roles()->detach(5);
        }else if(Auth::user()->current_role_id == 6){
          in_array(6, $request['role']) ? $user->roles()->syncWithoutDetaching(6) : $user->roles()->detach(6);
        }

        if(!$user->roles->contains($user->current_role_id)){
          $user->update(['current_role_id' => null]);
        }
        
        return response([
          'message' => 'Role user ' . $user->nama . ' berhasil diupdate',
          'roles' => $user->roles->pluck('id'),
        ], 200);
    }
}
