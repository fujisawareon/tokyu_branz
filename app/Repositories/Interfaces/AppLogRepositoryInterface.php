<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\AppLog;
use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

interface AppLogRepositoryInterface
{
    /**
     * @param array $building_ids
     */
    public function getTotalViewCountByBuildingIds(array $building_ids);

    /**
     * @param array $param
     * @return AppLog
     */
    public function create(array $param): AppLog;
}
