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
        $fields = ['program', 'tipe', 'level', 'nomor', 'banyak-pertemuan', 'tanggal-mulai', 'ruangan', 'status', 'sort-by', 'pengajar', 'page'];
        if(!empty(array_diff($request->query->keys(), $fields))){
            $query = [
                'program' => $request->query('program') ?? null,
                'tipe' => $request->query('tipe') ?? null,
                'level' => $request->query('level') ?? null,
                'nomor' => $request->query('nomor') ?? null,
                'banyak-pertemuan' => $request->query('banyak-pertemuan') ?? null,
                'tanggal-mulai' => $request->query('tanggal-mulai') ?? null,
                'ruangan' => $request->query('ruangan') ?? null,
                'status' => $request->query('status') ?? null,
                'sort-by' => $request->query('sort-by') ?? null,
                'pengajar' => $request->query('pengajar') ?? null,
                'page' => $request->query('page') ?? null,
            ];
            return redirect()->route('kelas.index', $query);
        }

        return $next($request);
    }
}
