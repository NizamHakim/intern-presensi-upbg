<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public $inputName;
    public $value;
    public $checked;
    public $label;
    
    public function __construct($inputName, $value, $checked, $label = null)
    {
        $this->inputName = $inputName;
        $this->value = $value;
        $this->checked = $checked;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.checkbox');
    }
}
