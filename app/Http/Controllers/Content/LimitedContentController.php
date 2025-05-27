<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Services\BuildingService;

class LimitedContentController extends Controller
{
    protected BuildingService $building_service;

    public function __construct()
    {
        $this->building_service = app(BuildingService::class);
    }

}
