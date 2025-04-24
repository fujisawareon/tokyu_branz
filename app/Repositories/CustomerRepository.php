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
     * @see CustomerRepositoryInterface::getEntryCustomerCountByBuildingIds()
     */
    public function getEntryCustomerCountByBuildingIds(array $building_ids): \Illuminate\Support\Collection
    {
        return CustomerBuilding::select('building_id', DB::raw('COUNT(*) as count'))
            ->whereIn('building_id', $building_ids)
            ->groupBy('building_id')
            ->orderBy('building_id')
            ->pluck('count', 'building_id');
    }


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
