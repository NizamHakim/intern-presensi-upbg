<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoricalSearch extends Component
{
    public $options;
    public $selected;
    public $placeholder;
    public $value;

    public function __construct($options, $selected, $placeholder, $value)
    {
        $this->options = $options;
        $this->selected = $selected;
        $this->placeholder = $placeholder;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.categorical-search');
    }
}
