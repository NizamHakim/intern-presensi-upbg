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
    public $placeholder;

    public function __construct($selected, $options, $inputName, $label = null, $placeholder = null)
    {
        $this->options = $options->map(fn($option) => ['text' => $option['text'], 'value' => $option['value']]);
        if($placeholder){
            $this->options->prepend(['text' => $placeholder, 'value' => null]);
        }
        $this->selected = $selected ?? $this->options->first();
        $this->inputName = $inputName;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.dropdown');
    }
}
