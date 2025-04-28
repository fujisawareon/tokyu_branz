<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\BuildingRepositoryInterface;
use App\Models\Building;
use App\Traits\FormTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BuildingRepository implements BuildingRepositoryInterface
{
    use FormTrait;

    /**
     * @inheritDoc
     * @see BuildingRepositoryInterface::getBuildings()
     */
    public function getBuildings(): Collection
    {
        return Building::orderBy('id')->get();
    }

    /**
     * @inheritDoc
     * @see BuildingRepositoryInterface::getAllBuildings()
     */
    public function getAllBuildings(array $conditions): LengthAwarePaginator
    {

        $query = Building::orderBy('created_at', 'desc')
            ->orderBy('id', 'asc');

        if (!empty($conditions['building_name'])) {
            $query = $this->setLikeWhere($query, 'building_name', $conditions['building_name']);
        }

        return $query->paginate(30);
    }

    /**
     * @inheritDoc
     * @see BuildingRepositoryInterface::create()
     */
    public function create(array $request_data): Building
    {
        return Building::create($request_data);
    }

    /**
     * @inheritDoc
     * @see BuildingRepositoryInterface::update()
     */
    public function update(Building $building, array $request_data): bool
    {
        return $building->update($request_data);
    }
}
