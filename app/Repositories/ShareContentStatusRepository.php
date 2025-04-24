<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\DisplayCustomerListColumn;
use App\Models\MasterData;
use App\Models\ShareContentStatus;
use App\Repositories\Interfaces\ShareContentStatusRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ShareContentStatusRepository implements ShareContentStatusRepositoryInterface
{
    /**
     * @inheritDoc
     * @see ShareContentStatusRepositoryInterface::getByBuildingIdAndStatusId()
     */
    public function getByBuildingIdAndStatusId(int $building_id, int $status_id): Collection
    {
        return ShareContentStatus::where('building_id', $building_id)
            ->where('status_id', $status_id)
            ->get();
    }

    /**
     * @inheritDoc
     * @see ShareContentStatusRepositoryInterface::deleteShareContentsList()
     */
    public function deleteShareContentsList(int $building_id, int $status_id, int $manager_id)
    {
        $query = ShareContentStatus::where('building_id', $building_id)
            ->where('status_id', $status_id);

        return $query->update([
            'updated_by' => $manager_id,
            'deleted_at' => Carbon::now(),
        ]);
    }

    /**
     * @inheritDoc
     * @see ShareContentStatusRepositoryInterface::insert()
     */
    public function insert(array $records)
    {
        return ShareContentStatus::insert($records);
    }
}
