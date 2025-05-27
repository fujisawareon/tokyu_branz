<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

interface CustomerBuildingRepositoryInterface
{
    /**
     * @param int $customer_id
     * @return Collection<int, Building>
     */
    public function getByCustomerId(int $customer_id): Collection;
}
