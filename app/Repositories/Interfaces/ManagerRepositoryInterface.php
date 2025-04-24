<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ManagerRepositoryInterface
{
    /**
     * @return LengthAwarePaginator<int, Manager>
     */
    public function getManagers(): LengthAwarePaginator;

    /**
     */
    public function update(Manager $manager, array $param);

}
