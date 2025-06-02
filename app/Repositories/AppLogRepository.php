<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AppLog;
use App\Repositories\Interfaces\AppLogRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class AppLogRepository implements AppLogRepositoryInterface
{
    /**
     * @inheritDoc
     * @see AppLogRepositoryInterface::getTotalViewCountByBuildingIds()
     */
    public function getTotalViewCountByBuildingIds(array $building_ids)
    {
        return AppLog::whereIn('building_id', $building_ids)->count();
    }

}
