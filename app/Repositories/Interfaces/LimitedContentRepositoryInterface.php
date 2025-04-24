<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\LimitedContents;
use Illuminate\Database\Eloquent\Collection;

interface LimitedContentRepositoryInterface
{
    /**
     * 対象物件で設定した限定コンテンツを取得する
     * @param int $building_id
     * @return Collection<int, LimitedContents>
     */
    public function getByBuildingId(int $building_id): Collection;

    /**
     * 限定コンテンツを作成する
     * @param array $record
     * @return LimitedContents
     */
    public function create(array $record): LimitedContents;

    /**
     * 特定の限定コンテンツを更新する
     * @param LimitedContents $limited_content
     * @param array $param
     */
    public function overwrite(LimitedContents $limited_content, array $param): bool;

}
