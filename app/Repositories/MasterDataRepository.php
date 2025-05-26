<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Consts\CacheConsts;
use App\Repositories\Interfaces\MasterDataRepositoryInterface;
use App\Models\MasterData;
use App\Traits\CacheTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class MasterDataRepository implements MasterDataRepositoryInterface
{
    use CacheTrait;

    /**
     * @inheritDoc
     * @see MasterDataRepositoryInterface::getMasterDataByDataType()
     */
    public function getMasterDataByDataType(int $type): Collection
    {
        $key_name = $this->makeKeyName(CacheConsts::KEY_NAME_TYPE_MASTER_DATA, [
            'type' => $type,
        ]);

        // キャッシュにあればそのまま利用する
        if (Cache::has($key_name)) {
            return Cache::get($key_name);
        }

        $master_data = MasterData::where('data_type', $type)
            ->orderBy('sort')
            ->get();

        // 1時間キャッシュに保存
        Cache::put($key_name, $master_data, 3600);

        return $master_data;
    }


}
