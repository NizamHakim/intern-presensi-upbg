<?php

namespace App\View\Components\Kelas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JadwalDynamic extends Component
{
    public $hariOptions;
    public $kelas;

    public function __construct($hariOptions, $kelas = null)
    {
        $this->hariOptions = $hariOptions;
        $this->kelas = $kelas;
    }

    public function render(): View|Closure|string
    {
        return view('kelas.partials.jadwal-dynamic');
    }
}
