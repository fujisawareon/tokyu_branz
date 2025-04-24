<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\CustomerPin;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerPinRepositoryInterface
{
    /**
     * @param int $building_id
     * @param int $manager_id
     * @param int $customer_id
     */
    public function getRecord(int $building_id, int $manager_id , int $customer_id);

    /**
     */
    public function create(array $param);

    /**
     * @param CustomerPin $customer_pin
     * @return bool
     */
    public function delete(CustomerPin $customer_pin): bool;
}
