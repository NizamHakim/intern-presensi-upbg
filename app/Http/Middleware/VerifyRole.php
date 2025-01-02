<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        return $next($request);
    }
}
