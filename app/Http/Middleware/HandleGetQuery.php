<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleGetQuery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        switch ($request->route()->getName()) {
            case 'kelas.index':
                $fields = ['program', 'tipe', 'level', 'nomor', 'banyak-pertemuan', 'tanggal-mulai', 'ruangan', 'status', 'sort-by', 'pengajar', 'page', 'search'];
                $checkQuery = $this->checkQuery($request, $fields);
                if($checkQuery['shouldRedirect']) return redirect()->route('kelas.index', $checkQuery['query']);
                break;
            case 'user.index':
                $fields = ['role', 'nama', 'nik-nip', 'page'];
                $checkQuery = $this->checkQuery($request, $fields);
                if($checkQuery['shouldRedirect']) return redirect()->route('user.index', $checkQuery['query']);
                break;
            case 'peserta.index':
                $fields = ['nama', 'nik-nrp', 'occupation', 'page'];
                $checkQuery = $this->checkQuery($request, $fields);
                if($checkQuery['shouldRedirect']) return redirect()->route('peserta.index', $checkQuery['query']);
                break;
        }
        return $next($request);
    }

    private function checkQuery($request, $fields)
    {
        $shouldRedirect = false;
        $query = [];
        foreach ($request->query() as $key => $value) {
            if (!in_array($key, $fields) || $value === null) {
                $shouldRedirect = true;
                continue;
            }else{
                $query[$key] = $value;
            }
        }
        return ['shouldRedirect' => $shouldRedirect, 'query' => $query];
    }
}
