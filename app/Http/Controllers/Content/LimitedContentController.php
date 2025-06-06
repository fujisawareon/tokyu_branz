<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Customer;
use App\Models\MasterData;
use App\Repositories\Interfaces\MasterDataRepositoryInterface;
use App\Services\BuildingService;
use App\Services\BuildingSettingService;
use App\Services\ImageGalleryService;

class LimitedContentController extends Controller
{
    protected BuildingService $building_service;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->building_service = app(BuildingService::class);
    }

    /**
     * 閲覧可能なメニューかチェックする
     * @param string $page_name
     * @return true
     */
    protected function checkURL(string $page_name):bool
    {
        return true;
    }

    /**
     * 閲覧可能な限定コンテンツのメニューを取得する
     * @param int $building_id
     * @param Customer|null $customer ※プレゼンモードの場合はnull
     * @return array
     */
    protected function getContentsMenu(int $building_id, ?Customer $customer = null): array
    {
        /** @var MasterDataRepositoryInterface $master_data_repository */
        $master_data_repository = app(MasterDataRepositoryInterface::class);

        /** @var BuildingSettingService $building_setting_service */
        $building_setting_service = app(BuildingSettingService::class);

        // マスターを取得
        $master_data_collection = $master_data_repository->getMasterDataByDataType(MasterData::LIMITED_CONTENT)->pluck('name', 'data_key');

        // 限定コンテンツ設定を取得
        $limited_content_manu = $building_setting_service->getEnableLimitedContentList($building_id)->pluck('data_key');

        // 合わせてフィルター＆順序付け
        return $limited_content_manu->mapWithKeys(function ($key) use ($master_data_collection) {
                return [$key => $master_data_collection->get($key)];
            })
            ->all();
    }

    /**
     * 閲覧する画面に必要なデータを取得する
     * @param int $building_id
     * @param string $page_name
     * @param bool $presentation_mode
     * @return array
     */
    protected function getPageData(Building $building, string $page_name, bool $presentation_mode = false)
    {
        return match ($page_name) {
            'image_gallery' => $this->getImageGallery($building),
            default => [],
        };
    }

    /**
     * @param Building $building
     * @return array
     */
    private function getImageGallery(Building $building): array
    {
        return [
            'image_gallery_annotation' => $building->buildingSetting->image_gallery_annotation,
            'image_gallery' => (new ImageGalleryService())->getByBuildingId($building->id),
        ];
    }
}
