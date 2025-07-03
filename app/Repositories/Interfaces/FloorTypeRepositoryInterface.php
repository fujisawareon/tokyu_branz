<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\ImageGallery;
use Illuminate\Database\Eloquent\Collection;

interface FloorTypeRepositoryInterface
{
    /**
     * @param int $building_id
     * @return Collection<int, ImageGallery>
     */
    public function getByBuildingId(int $building_id): Collection;

}
