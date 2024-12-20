<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('public.login');
    }

    public function handleLoginRequest(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();

            switch($user->current_role_id){
                case(2):
                    return redirect()->intended(route('kelas.index'));
                case(3):
                    return redirect()->intended(route('kelas.index'));
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function switchRole(Request $request)
    {
        User::findOrFail(Auth::id())->update(['current_role_id' => $request['role_id']]);

        return redirect()->route('kelas.index');
    }

    public function handleLogoutRequest()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('auth.loginPage');
    }
}
