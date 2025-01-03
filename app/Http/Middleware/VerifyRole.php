<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    { 
      if(Auth::user()->current_role_id == null){
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        if ($request->ajax()) {
          return response([
            'error' => 'Sesi telah berakhir, silahkan login kembali',
            'redirect' => route('auth.loginPage')
          ], 419);
        }
        return redirect()->route('auth.loginPage');
      }

      if(!in_array(Auth::user()->current_role_id, $roles)){
        if($request->ajax()){
          return response([
            'error' => 'Anda tidak memiliki akses untuk melakukan tindakan ini',
          ], 401);
        }
        return redirect()->route('home');
      }
      return $next($request);
    }
}
