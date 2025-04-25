<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ActionBtnSetting;
use App\Repositories\Interfaces\ActionBtnSettingRepositoryInterface;
use Carbon\Carbon;

class ActionBtnSettingRepository implements ActionBtnSettingRepositoryInterface
{
    /**
     * @inheritDoc
     * @see ActionBtnSettingRepositoryInterface::insert()
     */
    public function insert(array $records): bool
    {
        return ActionBtnSetting::insert($records);
    }

    /**
     * @inheritDoc
     * @see ActionBtnSettingRepositoryInterface::update()
     */
    public function update(ActionBtnSetting $action_btn_setting, array $param): bool
    {
        return $action_btn_setting->update($param);
    }

    /**
     * @inheritDoc
     * @see ActionBtnSettingRepositoryInterface::deleteByBuildingId()
     */
    public function deleteByBuildingId(int $building_id, int $manager_id): int
    {
        return ActionBtnSetting::where('building_id', $building_id)->update([
            'updated_by' => $manager_id,
            'deleted_at' => Carbon::now(),
        ]);
    }

    /**
     * @inheritDoc
     * @see ActionBtnSettingRepositoryInterface::deleteByIds()
     */
    public function deleteByIds(int $building_id, array $delete_ids, int $manager_id): int
    {
        return ActionBtnSetting::where('building_id', $building_id)
            ->whereIn('id', $delete_ids)->update([
            'updated_by' => $manager_id,
            'deleted_at' => Carbon::now(),
        ]);
    }

}
