<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CustomerBuilding;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @inheritDoc
     * @see CustomerRepositoryInterface::createCustomer()
     */
    public function createCustomer(array $param): Customer
    {
        return Customer::create($param);
    }

    /**
     * @inheritDoc
     * @see CustomerRepositoryInterface::createCustomerBuildingRelation()
     */
    public function createCustomerBuildingRelation(int $customer_id, int $building_id): CustomerBuilding
    {
        return CustomerBuilding::create([
            'customer_id' => $customer_id,
            'building_id' => $building_id,
            'relation_status' => CustomerBuilding::ENABLED,
        ]);
    }

}
