<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMustNull
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->current_role_id !== null) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
