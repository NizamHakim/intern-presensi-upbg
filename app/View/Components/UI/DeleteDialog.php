<?php

namespace App\View\Components\UI;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteDialog extends Component
{
    public $inputName;
    public $useSoftDelete;
    public $action;
    public function __construct($action, $useSoftDelete = false)
    {
        $this->action = $action;
        $this->useSoftDelete = $useSoftDelete;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.delete-dialog');
    }
}
