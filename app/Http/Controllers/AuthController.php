<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('guest.login');
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
        return redirect()->intended(route('home'));
      }

      return back()->withErrors([
          'email' => 'Email atau password salah',
      ])->onlyInput('email');
    }

    public function loginRoles()
    {
      return view('login-roles');
    }

    public function switchRole(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        if(!$user->roles->contains($request['role-id'])){
            return redirect()->back();
        }
        $user->update(['current_role_id' => $request['role-id']]);
        return redirect()->back();
    }

    public function handleLogoutRequest()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('auth.loginPage');
    }
}
