<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Number extends Component
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

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.number');
    }
}
