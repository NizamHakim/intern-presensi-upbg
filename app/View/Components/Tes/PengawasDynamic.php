<?php

namespace App\View\Components\Tes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PengawasDynamic extends Component
{
    public $pengawasOptions;
    public $tes;
    
    public function __construct($pengawasOptions, $tes = null)
    {
        $this->pengawasOptions = $pengawasOptions;
        $this->tes = $tes;
    }

    public function render(): View|Closure|string
    {
        return view('tes.partials.pengawas-dynamic');
    }
}
