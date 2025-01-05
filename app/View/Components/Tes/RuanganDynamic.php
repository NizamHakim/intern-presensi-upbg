<?php

namespace App\View\Components\Tes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RuanganDynamic extends Component
{
    public $ruanganOptions;
    public $tes;

    public function __construct($ruanganOptions, $tes = null)
    {
        $this->ruanganOptions = $ruanganOptions;
        $this->tes = $tes;
    }

    public function render(): View|Closure|string
    {
        return view('tes.partials.ruangan-dynamic');
    }
}
