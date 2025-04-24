<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Customer;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as CollectionAlias;

interface CustomerRepositoryInterface
{
    /**
     * 複数物件のエントリー数を取得する
     * @param array $building_ids
     * @return CollectionAlias<array>
     */
    public function getEntryCustomerCountByBuildingIds(array $building_ids): CollectionAlias;

    /**
     * @param array $param
     * @return Customer
     */
    public function createCustomer(array $param): Customer;

    /**
     */
    public function createCustomerBuildingRelation(int $customer_id, int $building_id);

}
