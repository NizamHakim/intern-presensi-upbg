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
    
    public function __construct($type, $inputName, $value)
    {
        $this->type = $type;
        $this->inputName = $inputName;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.checkbox');
    }
}
