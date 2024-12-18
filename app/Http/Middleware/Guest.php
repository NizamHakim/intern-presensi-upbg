<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->current_role_id;
            
            if(!$role){
                $role = Auth::user()->roles->first();
                User::findOrFail(Auth::id())->update(['current_role_id' => $role->id]);
            }

            switch ($role) {
                case 2:
                    return redirect()->route('kelas.index');
                case 3:
                    return redirect()->route('kelas.index');
            }
        }
        return $next($request);
    }
}
