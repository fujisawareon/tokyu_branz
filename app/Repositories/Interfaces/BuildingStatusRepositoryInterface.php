<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\BuildingSetting;

interface BuildingStatusRepositoryInterface
{
    /**
     * 対象物件と対になる物件設定情報を取得する
     * @param int $building_id
     * @return ?BuildingSetting
     */
    public function find(int $building_id): ?BuildingSetting;

    /**
     * 物件設定情報をデフォルトの状態で作成する
     * @param int $building_id
     * @return BuildingSetting
     */
    public function createDefault(int $building_id): BuildingSetting;

    /**
     * 物件設定情報を登録する
     * @param array $param
     * @return BuildingSetting
     */
    public function create(array $param): BuildingSetting;

    /**
     * 物件設定情報の更新を行う
     * @param BuildingSetting $building_setting
     * @param array $param
     * @return bool
     */
    public function update(BuildingSetting $building_setting, array $param): bool;
}
