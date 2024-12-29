<?php

namespace App\View\Components\Inputs\CategoricalSearch;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Option extends Component
{
    public $name;
    public $placeholder;
    
    public function __construct($name, $placeholder)
    {
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.categorical-search.option');
    }
}
