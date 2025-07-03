<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\FloorType;
use App\Repositories\Interfaces\FloorTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FloorTypeRepository implements FloorTypeRepositoryInterface
{
    /**
     * @inheritDoc
     * @see FloorTypeRepositoryInterface::getByBuildingId()
     */
    public function getByBuildingId(int $building_id): Collection
    {
        return FloorType::where('building_id', $building_id)
            ->orderBy('sort')
            ->get();
    }

}
