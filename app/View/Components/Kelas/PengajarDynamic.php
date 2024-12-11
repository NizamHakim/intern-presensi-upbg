<?php

namespace App\View\Components\Kelas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PengajarDynamic extends Component
{
    public $type;
    public $pengajarOptions;
    public $pengajarKelas;

    public function __construct($type, $pengajarOptions, $pengajarKelas)
    {
        $this->type = $type;
        $this->pengajarOptions = $pengajarOptions;
        $this->pengajarKelas = $pengajarKelas;
    }

    public function render(): View|Closure|string
    {
        return view('components.kelas.pengajar-dynamic');
    }
}
