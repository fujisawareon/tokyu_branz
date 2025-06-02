<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Building;
use App\Models\Customer;
use App\Repositories\Interfaces\AppLogRepositoryInterface;
use App\Repositories\Interfaces\BuildingRepositoryInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    /**
     * @param array $request
     * @return Builder
     */
    public function makeBuildingGetQuery(array $request): Builder
    {
        $select = [
            'buildings.id',
            'buildings.building_name',
            'buildings.sales_status',
            DB::raw('IFNULL(entry_counts.count, 0) as entry_count'),
            DB::raw('IFNULL(registration_counts.count, 0) as registration_count'),
            DB::raw('IFNULL(view_counts.view_count, 0) as view_count'),
        ];

        $query = Building::query()
            ->select($select)
            // エントリー数
            ->leftJoin(DB::raw('(
                    SELECT customer_building.building_id, COUNT(*) AS count
                    FROM customer_building
                    WHERE customer_building.deleted_at IS NULL
                    GROUP BY customer_building.building_id
                ) as entry_counts'), 'buildings.id', '=', 'entry_counts.building_id')
            // 登録者数
            ->leftJoin(DB::raw('(
                    SELECT customer_building.building_id, COUNT(*) AS count
                    FROM customer_building
                    INNER JOIN customers ON customers.id = customer_building.customer_id
                    WHERE customers.email_verified_at IS NOT NULL
                    GROUP BY customer_building.building_id
                ) as registration_counts'), 'buildings.id', '=', 'registration_counts.building_id')
            // 閲覧ページ数
            ->leftJoin(DB::raw('(
                    SELECT app_log.building_id, COUNT(*) AS view_count
                    FROM app_log
                    GROUP BY app_log.building_id
                ) as view_counts'), 'buildings.id', '=', 'view_counts.building_id');

        // 物件名
        if (isset($request['building_name'])) {
            // 全角スペースを半角スペースに変換して、空白で分割
            $keywords = preg_split('/\s+/', mb_convert_kana($request['building_name'], 's'));

            $query->where(function ($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->where('buildings.building_name', 'LIKE', "%$word%");
                }
            });
        }

        if (isset($request['sales_status'])) {
            $query->where('buildings.sales_status', $request['sales_status']);
        }



        return $query;
    }

}
