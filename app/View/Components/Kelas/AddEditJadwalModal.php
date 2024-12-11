<?php

namespace App\View\Components\Kelas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddEditJadwalModal extends Component
{
    public $hariOptions;
    public function __construct($hariOptions)
    {
        $this->hariOptions = $hariOptions;
    }

    public function render(): View|Closure|string
    {
        return view('components.kelas.add-edit-jadwal-modal');
    }
}
