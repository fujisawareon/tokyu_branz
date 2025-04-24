<?php

declare(strict_types=1);

namespace App\Services;

use App\Consts\CommonConsts;
use App\Models\MasterData;
use App\Models\ShareContentStatus;
use App\Repositories\Interfaces\ShareContentStatusRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class LimitedContentsShareService
{
    private ShareContentStatusRepositoryInterface $share_content_status_repository;

    /**
     */
    public function __construct()
    {
        $this->share_content_status_repository = app( ShareContentStatusRepositoryInterface::class);
    }

    /**
     * @param int $building_id
     * @param int $status_id
     * @return Collection<int, ShareContentStatus>
     */
    public function getShareContentsList(int $building_id, int $status_id): Collection
    {
        return $this->share_content_status_repository->getByBuildingIdAndStatusId($building_id, $status_id);
    }

    /**
     * @param int $building_id
     * @param int $status_id
     * @param int $manager_id
     * @return int
     */
    public function deleteShareContentsList(int $building_id, int $status_id, int $manager_id): int
    {
        return $this->share_content_status_repository->deleteShareContentsList($building_id, $status_id, $manager_id);
    }

    /**
     * @param int $building_id
     * @param int $status_id
     * @param int $manager_id
     * @param array $contents_list
     * @return bool
     */
    public function insertShareContentsList(int $building_id, int $status_id, int $manager_id, array $contents_list): bool
    {
        $records = [];
        foreach ($contents_list as $content_name => $content_value) {
            $records[] = [
                'building_id' => $building_id,
                'status_id' => $status_id,
                'content_key' => $content_name,
                'created_by' => $manager_id,
            ];
        }

        return $this->share_content_status_repository->insert($records);
    }

}
