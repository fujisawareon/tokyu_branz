<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MasterData;
use App\Repositories\Interfaces\ShareItemStatusRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ShareItemService
{
    private ShareItemStatusRepositoryInterface $share_item_status_repository;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->share_item_status_repository = app(ShareItemStatusRepositoryInterface::class);
    }

    /**
     * @param int $building_id
     * @param int $selected_status_id
     * @return Collection
     */
    public function getShareItemByStatusId(int $building_id, int $selected_status_id)
    {
        return $this->share_item_status_repository->getShareItemByStatusId($building_id, $selected_status_id);
    }

    /**
     * @param int $building_id
     * @param int $status_id
     * @param array $action_btn
     * @return mixed
     */
    public function updateShareContentsList(int $building_id, int $status_id, ?array $action_btn)
    {
        if (is_null($action_btn)) {
            return;
        }
        $records = [];
        foreach ($action_btn as $action_btn_id) {
            $records[] = [
                'building_id' => $building_id,
                'status_id' => $status_id,
                'data_type' => MasterData::LIMITED_CONTENT,
                'external_id' => $action_btn_id,
                'created_by' => Auth::guard('managers')->user()->id,
            ];
        }

        return $this->share_item_status_repository->insert($records);
    }

    /**
     * @param int $building_id
     * @param int $status_id
     * @param int $manager_id
     * @return int
     */
    public function deleteShareItemList(int $building_id, int $status_id, int $manager_id): int
    {
        return $this->share_item_status_repository->deleteShareContentsList($building_id, $status_id, $manager_id);
    }
}
