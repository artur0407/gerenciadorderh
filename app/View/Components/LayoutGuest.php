<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LayoutGuest extends Component
{
    public $pageTitle;

    public function __construct($pageTitle = null)
    {
        $this->pageTitle = $pageTitle;
    }

    public function render(): View|Closure|string
    {
        return view('components.layout-guest');
    }
}
