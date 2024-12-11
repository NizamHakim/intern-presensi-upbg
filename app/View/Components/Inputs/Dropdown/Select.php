<?php

namespace App\View\Components\Inputs\Dropdown;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $placeholder;
    public $selected;

    public function __construct($name, $placeholder = null, $selected = null)
    {
        $this->name = $name;
        $this->placeholder = $placeholder;
        if($selected == null){
            $this->selected = ['text' => $placeholder, 'value' => null];
        }else{
            $this->selected = $selected;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.dropdown.select');
    }
}
