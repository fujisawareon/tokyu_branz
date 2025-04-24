<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Services\AppLogService;
use App\Services\BuildingService;
use App\Services\DashboardService;
use App\Traits\FormTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestController extends Controller
{
    use FormTrait;


    public function __construct()
    {
    }

    public function __invoke(Request $request): RedirectResponse|View
    {

        return view('manager.test', [
        ]);
    }

}
