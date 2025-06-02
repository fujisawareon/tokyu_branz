<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class LimitedContentsLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.limited_contents.app');
    }
}
