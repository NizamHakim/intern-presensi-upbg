<?php

namespace App\Http\Controllers;

use App\Helpers\RouteGraph;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function create()
    {
        $roleOptions = Role::where('id', 2)->orWhere('id', 3)->get();
        $breadcrumbs = RouteGraph::generate('user.create');

        return view('user.tambah-user', [
            'roleOptions' => $roleOptions,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto-user' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nik-user' => 'required|numeric|unique:users,nik',
            'nama-user' => 'required|string',
            'email-user' => 'required|email|unique:users,email',
            'password-user' => 'required|string|min:8',
            'password-confirm-user' => 'required|same:password-user',
            'role' => 'nullable|array',
            'role.*' => 'exists:roles,id|in:2,3',
        ], [
            'foto-user.image' => 'Foto tidak valid',
            'foto-user.mimes' => 'Foto harus berformat jpeg, jpg, atau png',
            'foto-user.max' => 'Foto maksimal 2MB',
            'nik-user.required' => 'NIK/NIP tidak boleh kosong',
            'nik-user.numeric' => 'NIK/NIP tidak boleh mengandung huruf',
            'nik-user.unique' => 'NIK/NIP sudah terdaftar',
            'nama-user.required' => 'Nama tidak boleh kosong',
            'email-user.required' => 'Email tidak boleh kosong',
            'email-user.email' => 'Email tidak valid',
            'email-user.unique' => 'Email sudah terdaftar',
            'password-user.required' => 'Password tidak boleh kosong',
            'password-user.min' => 'Password minimal 8 karakter',
            'password-confirm-user.required' => 'Konfirmasi password tidak boleh kosong',
            'password-confirm-user.same' => 'Konfirmasi password salah',
            'role.*.exists' => 'Role tidak valid',
            'role.*.in' => 'Unauthorized role assignment',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $user = User::create([
            'nik' => $request['nik-user'],
            'nama' => $request['nama-user'],
            'email' => $request['email-user'],
            'password' => bcrypt($request['password-user'])
        ]);

        if(isset($request['role'])){
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

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'User ' . $request['nama-user'] . ' berhasil ditambahkan'
        ]);

        return response(['redirect' => route('user.index')], 201);
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);
        $roleOptions = Role::where('id', 2)->orWhere('id', 3)->get();
        $breadcrumbs = RouteGraph::generate('user.detail', $user->nama);

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
            'role' => 'required|exists:roles,id|in:2,3',
            'checked' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        if($request['checked']){
            $user->roles()->attach($request['role']);
            if($user->current_role_id == null){
                $user->current_role_id = $request['role'];
            }
        }else{
            $user->roles()->detach($request['role']);
            if($user->current_role_id == $request['role']){
                if($user->roles->count() > 0){
                    $user->current_role_id = $user->roles->first()->id;
                }else{
                    $user->current_role_id = null;
                }
            }
        }

        $user->save();

        return response(['message' => 'Berhasil mengubah role'], 200);
    }
}
