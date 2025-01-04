<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tes;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyOwnership
{
    public function handle(Request $request, Closure $next, $role): Response
    {
      if($role == 'pengajaran'){
        if(Auth::user()->current_role_id == 1 || Auth::user()->current_role_id == 2 || Auth::user()->current_role_id == 6){
          return $next($request);
        }

        $kelas = Kelas::where('slug', $request->route('slug'))->first();
        if(!$kelas){
          if($request->ajax()){
            return response()->json([
              'error' => 'Kelas tidak ditemukan, silahkan refresh dan coba lagi'
            ], 404);
          }
          abort(404);
        }

        if(!$kelas->pengajar()->where('user_id', Auth::user()->id)->exists()){
          if($request->ajax()){
            return response()->json([
              'error' => 'Anda tidak memiliki akses untuk melakukan tindakan ini'
            ], 401);
          }
          abort(401);
        }

        return $next($request);
      }else if($role == 'tes'){
        if(Auth::user()->current_role_id == 1 || Auth::user()->current_role_id == 4 || Auth::user()->current_role_id == 6){
          return $next($request);
        }

        $tes = Tes::where('slug', $request->route('slug'))->first();
        if(!$tes){
          if($request->ajax()){
            return response()->json([
              'error' => 'Tes tidak ditemukan, silahkan refresh dan coba lagi'
            ], 404);
          }
          abort(404);
        }

        if(!$tes->pengawas()->where('user_id', Auth::user()->id)->exists()){
          if($request->ajax()){
            return response()->json([
              'error' => 'Anda tidak memiliki akses untuk melakukan tindakan ini'
            ], 401);
          }
          abort(401);
        }

        return $next($request);
      }
    }
}
