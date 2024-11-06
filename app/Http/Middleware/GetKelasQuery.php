<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetKelasQuery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $fields = ['program', 'tipe', 'level', 'nomor', 'banyakPertemuan', 'tanggalMulai', 'ruangan', 'status', 'sortBy'];
        if(!empty(array_diff($request->query->keys(), $fields))){
            $query = [
                'program' => $request->query('program') ?? null,
                'tipe' => $request->query('tipe') ?? null,
                'level' => $request->query('level') ?? null,
                'nomor' => $request->query('nomor') ?? null,
                'banyakPertemuan' => $request->query('banyakPertemuan') ?? null,
                'tanggalMulai' => $request->query('tanggalMulai') ?? null,
                'ruangan' => $request->query('ruangan') ?? null,
                'status' => $request->query('status') ?? null,
                'sortBy' => $request->query('sortBy') ?? null,
            ];
            return redirect()->route('kelas.index', $query);
        }

        return $next($request);
    }
}
