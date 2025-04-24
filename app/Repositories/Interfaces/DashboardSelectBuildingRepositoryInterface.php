<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\DashboardSelectBuilding;
use Illuminate\Database\Eloquent\Collection;

interface DashboardSelectBuildingRepositoryInterface
{
    /**
     * @return Collection<int, DashboardSelectBuilding>
     */
    public function getSelectedBuildingIds(int $manager_id): Collection;

    /**
     */
    public function delete(int $manager_id);

    /**
     */
    public function updateSelectedBuildingIds(int $manager_id, array $selected_building_ids);

}
