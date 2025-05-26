<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Building;
use App\Repositories\Interfaces\AppLogRepositoryInterface;
use App\Repositories\Interfaces\BuildingRepositoryInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class BuildingService
{
    private AppLogRepositoryInterface $app_log_repository;
    private BuildingRepositoryInterface $building_repository;
    private CustomerRepositoryInterface $customer_repository;

    public function __construct()
    {
        $this->app_log_repository = app(AppLogRepositoryInterface::class);
        $this->building_repository = app(BuildingRepositoryInterface::class);
        $this->customer_repository = app(CustomerRepositoryInterface::class);
    }

    /**
     * 全ての物件を取得する
     * @return Collection<int, Building>
     */
    public function getBuildings(): Collection
    {
        return $this->building_repository->getBuildings();
    }

    /**
     * 販売中の物件を取得する
     * @return LengthAwarePaginator<int, Building>
     */
    public function getAllBuildings(array $conditions): LengthAwarePaginator
    {
        return $this->building_repository->getAllBuildings($conditions);
    }

    /**
     * 物件に対する各分析情報を取得する
     * @param array $building_ids
     * @return array
     */
    public function getAnalyticsData(array $building_ids): array
    {
        // エントリー数
        $entry_count = $this->customer_repository->getEntryCustomerCountByBuildingIds($building_ids);

        // 登録数 TODO

        // 閲覧ページ数
        $view_count = $this->app_log_repository->getViewCountByBuildingIds($building_ids);

        return compact('view_count', 'entry_count');
    }

    /**
     * 物件情報を登録する
     * @param array $request_data
     * @return Building
     */
    public function store(array $request_data): Building
    {
        $request_data['created_by'] = Auth::guard('managers')->user()->id;

        // 販売ステータスが無ければ販売前にしておく
        if (empty($request_data['sales_status'])) {
            $request_data['sales_status'] = Building::SALES_STATUS_BEFORE_SALE;
        }

        return $this->building_repository->create($request_data);
    }

    /**
     * 物件情報を更新する
     * @param Building $building
     * @param array $request_data
     * @return bool
     */
    public function update(Building $building, array $request_data): bool
    {
        return $this->building_repository->update($building, $request_data);
    }

}
