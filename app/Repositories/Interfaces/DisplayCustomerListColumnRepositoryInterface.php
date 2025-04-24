<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\DashboardSelectBuilding;
use App\Models\DisplayCustomerListColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface DisplayCustomerListColumnRepositoryInterface
{
    /**
     * @param int $building_id
     * @param bool $all
     * @return Collection<int, DisplayCustomerListColumn>
     */
    public function getByBuildingId(int $building_id, bool $all): Collection;

    /**
     * @param array $records
     */
    public function insert(array $records);

    /**
     * @param int $building_id
     * @param int $manager_id
     * @param bool $all
     */
    public function delete(int $building_id, int $manager_id, bool $all = false);

}
