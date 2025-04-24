<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BuildingRepositoryInterface
{
    /**
     * 全ての物件を取得する
     * @return Collection<int, Building>
     */
    public function getBuildings(): Collection;

    /**
     * 販売中の物件を取得する
     * @return LengthAwarePaginator<int, Building>
     */
    public function getAllBuildings(array $conditions): LengthAwarePaginator;

    /**
     * 物件の登録を行う
     * @param array $request_data
     * @return Building
     */
    public function create(array $request_data): Building;

    /**
     * 物件の更新を行う
     * @param Building $building
     * @param array $request_data
     * @return bool
     */
    public function update(Building $building, array $request_data): bool;
}
