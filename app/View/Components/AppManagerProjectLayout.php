<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\Building;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppManagerProjectLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.manager.project');
    }
}
