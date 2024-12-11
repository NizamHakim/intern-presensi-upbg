<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navlink extends Component
{
    public $href;
    public $routeName;
    public function __construct($href, $routeName)
    {
        $this->href = $href;    
        $this->routeName = $routeName;
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.navlink');
    }
}
