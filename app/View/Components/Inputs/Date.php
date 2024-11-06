<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Date extends Component
{
    public $inputName;
    public $value;
    public $label;
    public $placeholder;

    public function __construct($inputName, $value, $label, $placeholder)
    {
        $this->inputName = $inputName;
        $this->value = $value;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.date');
    }
}
