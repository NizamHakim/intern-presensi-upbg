<?php

namespace App\View\Components\Tes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class KodeTesFormer extends Component
{
    public $ruanganOptions;
    public $tipeOptions;
    public $tes;

    public function __construct($ruanganOptions, $tipeOptions, $tes = null)
    {
        $this->ruanganOptions = $ruanganOptions;
        $this->tipeOptions = $tipeOptions;
        $this->tes = $tes;
    }

    public function render(): View|Closure|string
    {
        return view('components.tes.kode-tes-former');
    }
}
