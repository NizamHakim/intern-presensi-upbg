<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
          if ($request->ajax()) {
            return response([
              'error' => 'Sesi telah berakhir, silahkan login kembali',
              'redirect' => route('auth.loginPage')
            ], 419);
          }
          return redirect()->route('auth.loginPage');
        }

        return $next($request);
    }
}
