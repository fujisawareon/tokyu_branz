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
     * @param array $param
     * @return Customer
     */
    public function createCustomer(array $param): Customer;

    /**
     */
    public function createCustomerBuildingRelation(int $customer_id, int $building_id);

}
