<?php

namespace App\View\Components\Kelas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilePeserta extends Component
{
  public $required;
  public function __construct($required = false)
  {
      $this->required = $required;
  }

  public function render(): View|Closure|string
  {
      return view('kelas.partials.file-peserta');
  }
}
