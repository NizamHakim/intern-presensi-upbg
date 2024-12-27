<?php

namespace App\View\Components\Kelas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PengajarDynamic extends Component
{
    public $pengajarOptions;
    public $kelas;

    public function __construct($pengajarOptions, $kelas = null)
    {
        $this->pengajarOptions = $pengajarOptions;
        $this->kelas = $kelas;
    }

    public function render(): View|Closure|string
    {
        return view('kelas.partials.pengajar-dynamic');
    }
}
