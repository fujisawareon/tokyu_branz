<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\ShareItemStatus;
use Illuminate\Database\Eloquent\Collection;

interface ShareItemStatusRepositoryInterface
{
    /**
     * @param int $building_id
     * @param int $selected_status_id
     * @return Collection<int,ShareItemStatus>
     */
    public function getShareItemByStatusId(int $building_id, int $selected_status_id): Collection;

    /**
     * @param array $records
     * @return mixed
     */
    public function insert(array $records);

    /**
     * @param int $building_id
     * @param int $status_id
     * @param int $manager_id
     * @return int
     */
    public function deleteShareContentsList(int $building_id, int $status_id, int $manager_id): int;

}
