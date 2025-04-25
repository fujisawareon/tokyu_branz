<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\ActionBtnSetting;

interface ActionBtnSettingRepositoryInterface
{
    /**
     * アクションボタン設定を複数登録する
     * @param array $records
     * @return bool
     */
    public function insert(array $records): bool;

    /**
     * 対象のアクションボタン設定の更新を行う
     * @param ActionBtnSetting $action_btn_setting
     * @param array $param
     * @return bool
     */
    public function update(ActionBtnSetting $action_btn_setting, array $param): bool;

    /**
     * 対象物件のアクションボタン設定を全て論理削除する
     * @param int $building_id
     * @param int $manager_id
     * @return int
     */
    public function deleteByBuildingId(int $building_id, int $manager_id): int;

    /**
     * 対象物件の特定のアクションボタン設定を論理削除する
     * @param int $building_id
     * @param array $delete_ids
     * @param int $manager_id
     * @return int
     */
    public function deleteByIds(int $building_id, array $delete_ids, int $manager_id): int;
}
