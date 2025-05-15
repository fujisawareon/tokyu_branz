<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MasterData;
use App\Models\ShareContentStatus;
use App\Models\ShareItemStatus;
use App\Repositories\Interfaces\ShareItemStatusRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ShareItemStatusRepository implements ShareItemStatusRepositoryInterface
{
    /**
     * @inheritDoc
     * @see ShareItemStatusRepositoryInterface::getShareItemByStatusId()
     */
    public function getShareItemByStatusId(int $building_id, int $selected_status_id): Collection
    {
        return ShareItemStatus::where('building_id', $building_id)->where('status_id', $selected_status_id)->get();
    }

    /**
     * @inheritDoc
     * @see ShareItemStatusRepositoryInterface::insert()
     */
    public function insert(array $records)
    {
        return ShareItemStatus::insert($records);
    }

    /**
     * @param int $building_id
     * @param int $status_id
     * @param int $manager_id
     * @return int
     */
    public function deleteShareContentsList(int $building_id, int $status_id, int $manager_id): int
    {
        $query = ShareItemStatus::where('building_id', $building_id)
            ->where('status_id', $status_id);

        return $query->update([
            'updated_by' => $manager_id,
            'deleted_at' => Carbon::now(),
        ]);
    }

}
