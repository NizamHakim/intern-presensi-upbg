<?php

namespace App\View\Components\Layouts\Partials;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SwitchRole extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.partials.switch-role');
    }
}
