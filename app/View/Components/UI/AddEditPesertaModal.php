<?php

namespace App\View\Components\UI;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddEditPesertaModal extends Component
{
    public function __construct()
    {

    }

    public function render(): View|Closure|string
    {
        return view('components.ui.add-edit-peserta-modal');
    }
}
