<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CustomerPin;
use App\Repositories\Interfaces\CustomerPinRepositoryInterface;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerPinRepository implements CustomerPinRepositoryInterface
{
    /**
     * @inheritDoc
     * @see CustomerPinRepositoryInterface::getRecord()
     */
    public function getRecord(int $building_id, int $manager_id , int $customer_id)
    {
        return CustomerPin::where('building_id', $building_id)
            ->where('manager_id', $manager_id)
            ->where('customer_id', $customer_id)
            ->first();
    }

    /**
     * @inheritDoc
     * @see CustomerPinRepositoryInterface::create()
     */
    public function create(array $param)
    {
        Log::warning($param);
        return CustomerPin::create($param);
    }

    /**
     * @inheritDoc
     * @see CustomerPinRepositoryInterface::delete()
     */
    public function delete(CustomerPin $customer_pin): bool
    {
        return $customer_pin->delete();
    }

}
