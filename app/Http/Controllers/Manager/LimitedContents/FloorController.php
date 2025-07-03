<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager\LimitedContents;

use App\Consts\SessionConst;
use App\Models\Building;
use App\Services\BuildingSettingService;
use App\Services\PlanService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

/**
 *
 */
class FloorController extends Controller
{
    private BuildingSettingService $building_setting_service;
    private PlanService $plan_service;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->building_setting_service = app(BuildingSettingService::class);
        $this->plan_service = app(PlanService::class);
    }

    /**
     * @param Building $building
     * @return View
     */
    public function index(Building $building): View
    {
        $plans = $this->plan_service->getByBuildingId($building->id);

        return view('manager.project.contents.limited_contents.plan', [
            'building' => $building,
            'plans' => $plans,
        ]);
    }

    /**
     * @param Building $building
     */
    public function updatePlan(Building $building)
    {
        try {
            // 注釈文の更新

            //
            dd($building);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['間取タイプを更新しました']);
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['間取タイプの更新に失敗しました']);
        }

    }

}
