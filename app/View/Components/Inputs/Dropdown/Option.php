<?php

namespace App\View\Components\Inputs\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Option extends Component
{
    public $value;
    public $selected;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.dropdown.option');
    }
}
