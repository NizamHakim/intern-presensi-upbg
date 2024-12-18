<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Date extends Component
{
    public $inputName;
    public $plugin;
    public $placeholder;
    public $value;

    public function __construct($inputName, $placeholder, $plugin = 'default', $value = null)
    {
        $this->inputName = $inputName;
        $this->placeholder = $placeholder;
        $this->plugin = $plugin;
        $this->value = $value;
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.date');
    }
}
