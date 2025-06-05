<?php

namespace App\View\Components;

use App\Models\Building;
use Illuminate\View\Component;
use Illuminate\View\View;

class LimitedContentsLayout extends Component
{
    public Building $building;
    public array $contents_menu;
    public ?int $app_log_id;

    public function __construct(Building $building, array $contentsMenu, ?int $appLogId)
    {
        $this->building = $building;
        $this->contents_menu = $contentsMenu;
        $this->app_log_id = $appLogId;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.limited_contents.app');
    }
}
