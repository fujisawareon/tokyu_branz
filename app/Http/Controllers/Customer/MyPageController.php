<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Building;
use App\Models\MasterData;
use App\Services\AppLogService;
use App\Services\BuildingService;
use App\Services\BuildingSettingService;
use App\Services\MasterDataService;
use App\Traits\FormTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 */
class MyPageController extends Controller
{
    use FormTrait;

    private BuildingService $building_service;
    private MasterDataService $master_data_service;

    public function __construct()
    {
        $this->building_service = app(BuildingService::class);
        $this->master_data_service = app(MasterDataService::class);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request): View
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customers')->user();
        $buildings = $customer->buildings;
        $buildings->load('buildingSetting', 'salesSchedule');

        foreach ($buildings as $building) {
            $building->filteredSalesSchedule = $building->salesSchedule
                ->filter(fn($s) => $s->display_flg === 1);
        }

        return view('customer.top', [
            'buildings' => $buildings,
            'sales_schedule_list' => $this->master_data_service->getMasterSalesScheduleData()->pluck('name', 'data_key')->toArray(),
        ]);
    }
}
