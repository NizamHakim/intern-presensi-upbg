<?php

namespace App\View\Components\Inputs\CategoricalSearch;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $placeholder;
    public $text;
    public $search;

    public function __construct($selected, $search = '')
    {
        $this->name = $selected['name'];
        $this->placeholder = $selected['placeholder'];
        $this->text = $selected['text'];
        $this->search = $search;
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.categorical-search.select');
    }
}
