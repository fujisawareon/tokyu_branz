<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\LimitedContents;
use App\Models\SalesSchedule;
use App\Models\ShareContentStatus;
use Illuminate\Database\Eloquent\Collection;

interface ShareContentStatusRepositoryInterface
{

    /**
     * @param int $building_id
     * @param int $status_id
     * @return Collection<int, ShareContentStatus>
     */
    public function getByBuildingIdAndStatusId(int $building_id, int $status_id): Collection;

    /**
     * @param int $building_id
     * @param int $status_id
     * @param int $manager_id
     */
    public function deleteShareContentsList(int $building_id, int $status_id, int $manager_id);

    /**
     */
    public function insert(array $records);
}
