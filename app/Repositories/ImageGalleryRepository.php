<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ImageGallery;
use App\Repositories\Interfaces\ImageGalleryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ImageGalleryRepository implements ImageGalleryRepositoryInterface
{
    /**
     * @inheritDoc
     * @see ImageGalleryRepositoryInterface::getByBuildingId()
     */
    public function getByBuildingId(int $building_id): Collection
    {
        return ImageGallery::where('building_id', $building_id)
            ->orderBy('sort')
            ->get();
    }

    /**
     * @inheritDoc
     * @see ImageGalleryRepositoryInterface::create()
     */
    public function create(array $param): ImageGallery
    {
        return ImageGallery::create($param);
    }


}
