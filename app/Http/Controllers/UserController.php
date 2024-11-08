<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roleOptions = Role::all()->map->only(['text', 'value'])->prepend(['text' => 'Semua', 'value' => null]);
        $roleSelected = ($request->query('role') != null) ? Role::findOrFail($request->query('role')) : null;
        return view('user.daftar-user', [
            'roleOptions' => $roleOptions,
            'roleSelected' => $roleSelected ? $roleSelected->only(['text', 'value']) : $roleOptions[0],
        ]);
    }
}
