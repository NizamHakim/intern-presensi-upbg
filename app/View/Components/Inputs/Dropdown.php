<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public $selected;
    public $options;
    public $label;
    public $inputName;
    public $style;

    public function __construct($selected, $options, $inputName, $label = null, $style = null)
    {
        $this->selected = $selected;
        $this->options = $options;
        $this->label = $label;
        $this->inputName = $inputName;
        $this->style = $style;
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.dropdown');
    }
}
