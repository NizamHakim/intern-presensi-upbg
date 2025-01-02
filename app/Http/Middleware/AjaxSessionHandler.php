<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AjaxSessionHandler
{
    public function handle(Request $request, Closure $next): Response
    {
      if ($request->ajax() && Auth::guest()) {
        return response([
          'message' => 'Session Expired',
        ], 401);
      }
      return $next($request);
    }
}
