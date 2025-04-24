<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerBuilding;
use App\Models\DisplayCustomerListColumn;
use App\Models\Manager;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\DisplayCustomerListColumnRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerAnalysisService
{
    private DisplayCustomerListColumnRepositoryInterface $display_customer_list_column_repository;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->display_customer_list_column_repository = app(DisplayCustomerListColumnRepositoryInterface::class);
    }

    /**
     * @param int $building_id
     * @param bool $all
     * @return array
     */
    public function getByBuildingId(int $building_id, bool $all): array
    {
        $display_customer_list_columns = $this->display_customer_list_column_repository->getByBuildingId($building_id, $all);
        return $display_customer_list_columns->pluck('item_name')->all();
    }

    /**
     * @param int $building_id
     * @param array $values
     * @return bool
     */
    public function insert(int $building_id, array $values): bool
    {
        $records = [];
        foreach ($values as $value) {
            $records[] = [
                'building_id' => $building_id,
                'item_name' => $value,
                'created_by' => Auth::guard('managers')->user()->id,
            ];
        }

        return $this->display_customer_list_column_repository->insert($records);
    }

    /**
     * @param Manager $manager
     * @return int
     */
    public function delete(int $building_id, Manager $manager): int
    {
        $all = $manager->role_type <= Manager::ROLE_TYPE_EMPLOYEE;
        if ($all) {
            return $this->display_customer_list_column_repository->delete($building_id, $manager->id, $all);
        } else {
            return $this->display_customer_list_column_repository->delete($building_id, $manager->id);
        }
    }
}
