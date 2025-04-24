<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\ManagerRepositoryInterface;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ManagerRepository implements ManagerRepositoryInterface
{
    /**
     * @inheritDoc
     * @see ManagerRepositoryInterface::getManagers()
     */
    public function getManagers(): LengthAwarePaginator
    {
        return Manager::paginate(20);
    }

    /**
     * @inheritDoc
     * @see ManagerRepositoryInterface::update()
     */
    public function update(Manager $manager, array $param)
    {
        $manager->update($param);
    }

}
