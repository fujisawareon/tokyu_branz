<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CustomerBuilding;
use App\Repositories\Interfaces\CustomerBuildingRepositoryInterface;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CustomerBuildingRepository implements CustomerBuildingRepositoryInterface
{
    /**
     * @inheritDoc
     * @see CustomerBuildingRepositoryInterface::getByCustomerId()
     */
    public function getByCustomerId(int $customer_id): Collection
    {
        return CustomerBuilding::get([
            'customer_id' => $customer_id,
            'building_id' => $building_id,
            'relation_status' => CustomerBuilding::ENABLED,
        ]);
    }
}
