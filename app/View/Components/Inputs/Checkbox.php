<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public $type;
    public $inputName;
    public $value;
    public $checked;
    
    public function __construct($type, $inputName, $value, $checked)
    {
        $this->type = $type;
        $this->inputName = $inputName;
        $this->value = $value;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.checkbox');
    }
}
