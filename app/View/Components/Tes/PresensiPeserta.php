<?php

namespace App\View\Components\Tes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PresensiPeserta extends Component
{
    public $tes;
    public $pesertaList;

    public function __construct($tes, $pesertaList)
    {
        $this->tes = $tes;
        $this->pesertaList = $pesertaList;
    }

    public function render(): View|Closure|string
    {
        return view('tes.partials.presensi-peserta');
    }
}
