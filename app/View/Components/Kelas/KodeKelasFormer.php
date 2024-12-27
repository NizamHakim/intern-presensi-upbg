<?php

namespace App\View\Components\Kelas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class KodeKelasFormer extends Component
{
    public $programOptions;
    public $tipeOptions;
    public $levelOptions;
    public $ruanganOptions;
    public $kelas;

    public function __construct($programOptions, $tipeOptions, $levelOptions, $ruanganOptions, $kelas = null)
    {
        $this->programOptions = $programOptions;
        $this->tipeOptions = $tipeOptions;
        $this->levelOptions = $levelOptions;
        $this->ruanganOptions = $ruanganOptions;
        $this->kelas = $kelas;
    }

    public function render(): View|Closure|string
    {
        return view('kelas.partials.kode-kelas-former');
    }
}
