<?php

namespace App\View\Components\Inputs\Dropdown;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $placeholder;
    public $text;
    public $value;

    public function __construct($name, $placeholder = null, $selected = null)
    {
        $this->name = $name;
        $this->placeholder = $placeholder;
        if($selected == null){
            $this->text = $placeholder;
            $this->value = '';
        }else{
            $this->text = $selected['text'];
            $this->value = $selected['value'];
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.dropdown.select');
    }
}
