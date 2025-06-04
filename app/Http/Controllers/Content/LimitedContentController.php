<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Services\BuildingService;
use App\Services\ImageGalleryService;

class LimitedContentController extends Controller
{
    protected BuildingService $building_service;

    public function __construct()
    {
        $this->building_service = app(BuildingService::class);
    }

    /**
     * @param string $page_name
     * @return true
     */
    protected function checkURL(string $page_name)
    {
        return true;
    }

    protected function getContentsMenu(): array
    {
        return [
            'image_gallery' => '画像ギャラリー',
            'plan' => '間取り',
        ];
    }

    /**
     * @param int $building_id
     * @param string $page_name
     * @param bool $presentation_mode
     * @return array
     */
    protected function getPageData(int $building_id, string $page_name, bool $presentation_mode = false)
    {
        return match ($page_name) {
            'image_gallery' => $this->getImageGallery($building_id, $presentation_mode),
            default => [],
        };
    }

    private function getImageGallery(int $building_id, bool $presentation_mode = false)
    {
        $image_gallery_service = app(ImageGalleryService::class);
        return $image_gallery_service->getByBuildingId($building_id);
    }
}
