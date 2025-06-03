<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Building;
use App\Models\ImageGallery;
use App\Repositories\Interfaces\ImageGalleryRepositoryInterface;
use App\Traits\CacheTrait;
use Illuminate\Database\Eloquent\Collection;

class ImageGalleryService
{
    use CacheTrait;

    private ImageGalleryRepositoryInterface $image_gallery_repository;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->image_gallery_repository = app(ImageGalleryRepositoryInterface::class);
    }

    /**
     * @param int $building_id
     * @return Collection<int, ImageGallery>
     */
    public function getByBuildingId(int $building_id): Collection
    {
        return $this->image_gallery_repository->getByBuildingId($building_id);
    }

    /**
     * @param array $param
     */
    public function create(array $param): void
    {
        $this->image_gallery_repository->create($param);
    }

}
