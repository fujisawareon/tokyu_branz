<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Building;
use App\Services\AppLogService;
use App\Services\BuildingService;
use App\Services\DashboardService;
use App\Traits\FormTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use FormTrait;

    private AppLogService $app_log_service;
    private BuildingService $building_service;
    private DashboardService $dashboard_service;

    public function __construct()
    {
        $this->building_service = app(BuildingService::class);
    }

    public function __invoke(Request $request)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customers')->user();
        $buildings = $customer->buildings;

        return view('customer.top', [
            'buildings' => $buildings,
        ]);
    }

}
