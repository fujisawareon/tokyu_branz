<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Consts\CacheConsts;
use App\Repositories\Interfaces\DashboardSelectBuildingRepositoryInterface;
use App\Models\DashboardSelectBuilding;
use App\Traits\CacheTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardSelectBuildingRepository implements DashboardSelectBuildingRepositoryInterface
{
    use CacheTrait;

    /**
     * @inheritDoc
     * @see DashboardSelectBuildingRepositoryInterface::getSelectedBuildingIds()
     */
    public function getSelectedBuildingIds(int $manager_id): Collection
    {
        $key_name = $this->makeKeyName(CacheConsts::KEY_NAME_TYPE_SELECTED_BUILDING, [
            'manager_id' =>$manager_id,
        ]);

        // キャッシュにあればそのまま利用する
        if (Cache::has($key_name)) {
            return Cache::get($key_name);
        }

        // キャッシュにないのでDBから取得
        $building_ids = DashboardSelectBuilding::where('manager_id', $manager_id)
            ->get();

        // 1時間キャッシュに保存
        Cache::put($key_name, $building_ids, 3600);

        return $building_ids;
    }

    /**
     * @inheritDoc
     * @see DashboardSelectBuildingRepositoryInterface::delete()
     */
    public function delete(int $manager_id)
    {
        return DashboardSelectBuilding::where('manager_id', $manager_id)
            ->delete();
    }

    /**
     * @inheritDoc
     * @see DashboardSelectBuildingRepositoryInterface::updateSelectedBuildingIds()
     */
    public function updateSelectedBuildingIds(int $manager_id, array $selected_building_ids)
    {
        $records = [];
        foreach ($selected_building_ids as $building_id) {
            $records[] = [
                'manager_id' => $manager_id,
                'building_id' => $building_id,
            ];
        }

        DashboardSelectBuilding::insert($records);

        // キャッシュを削除
        $this->cacheForget(CacheConsts::KEY_NAME_TYPE_SELECTED_BUILDING, [
            'manager_id' => $manager_id
        ]);

    }

}
