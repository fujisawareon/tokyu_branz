<?php

declare(strict_types=1);

namespace App\Traits;

use App\Consts\CacheConsts;
use App\Models\Building;
use App\Models\User;
use App\Repositories\Interfaces\DashboardSelectBuildingRepositoryInterface;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
trait CacheTrait
{
    /**
     * キャッシュタイプによるキーネームを作成する
     * @param int $type
     * @param array $params
     * @return string
     */
    private function makeKeyName(int $type, array $params) :string
    {
        return match ($type) {
            CacheConsts::KEY_NAME_TYPE_SELECTED_BUILDING => sprintf(CacheConsts::USER_SELECTED_BUILDING_IDS, $params['manager_id']),
            CacheConsts::KEY_NAME_TYPE_MASTER_DATA => sprintf(CacheConsts::MASTER_DATA, $params['type']),
            default => '',
        };

    }

    /**
     * キャッシュを全削除する
     * @return void
     */
    public function cacheFlush(): void
    {
        Cache::flush();
    }

    /**
     * キータイプによるキャッシュを削除する
     * @param int $type
     * @param array $params
     * @return void
     */
    public function cacheForget(int $type, array $params): void
    {
        $key_name = $this->makeKeyName($type, $params);
        Cache::forget($key_name);
    }

}