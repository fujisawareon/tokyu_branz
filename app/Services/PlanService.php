<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\FloorType;
use App\Repositories\Interfaces\FloorTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlanService
{
    private FloorTypeRepositoryInterface $floor_type_repository;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->floor_type_repository = app(FloorTypeRepositoryInterface::class);
    }

    /**
     * @param int $building_id
     * @return Collection<int, FloorType>
     */
    public function getByBuildingId(int $building_id): Collection
    {
        return $this->floor_type_repository->getByBuildingId($building_id);
    }


}
