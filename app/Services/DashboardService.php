<?php

declare(strict_types=1);

namespace App\Services;

use App\Consts\CacheConsts;
use App\Models\Building;
use App\Models\DashboardSelectBuilding;
use App\Repositories\Interfaces\DashboardSelectBuildingRepositoryInterface;
use App\Traits\CacheTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    private DashboardSelectBuildingRepositoryInterface $dashboard_repository;

    public function __construct()
    {
        $this->dashboard_repository = app(DashboardSelectBuildingRepositoryInterface::class);
    }

    /**
     * @return array<int, int>
     */
    public function getSelectedBuildingIds(): array
    {
        $manager_id = Auth::guard('managers')->user()->id;
        return $this->dashboard_repository->getSelectedBuildingIds($manager_id)->pluck('building_id')->all();
    }

    /**
     */
    public function updateSelectedBuildingIds(array $selected_building_ids)
    {
        $manager_id = Auth::guard('managers')->user()->id;
        // 一度削除
        $this->dashboard_repository->delete($manager_id);

        // 再登録
        $this->dashboard_repository->updateSelectedBuildingIds($manager_id, $selected_building_ids);

        // 再取得
        return $this->dashboard_repository->getSelectedBuildingIds($manager_id)->pluck('building_id')->all();
    }


}
