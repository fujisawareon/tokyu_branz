<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\MasterData;
use Illuminate\Database\Eloquent\Collection;

interface MasterDataRepositoryInterface
{

    /**
     * データタイプによるマスターデータを取得する
     * ※キャッシュにある場合はキャッシュから取得する
     * @param int $type
     * @return Collection<int, MasterData>
     */
    public function getMasterDataByDataType(int $type): Collection;

}
