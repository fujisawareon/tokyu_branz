<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\BinderRepositoryInterface;
use App\Models\BinderBuilding;
use App\Traits\FormTrait;
use Illuminate\Database\Eloquent\Collection;

class BinderRepository implements BinderRepositoryInterface
{
    /**
     * @inheritDoc
     * @see BinderRepositoryInterface::create()
     */
    public function create(array $param): BinderBuilding
    {
        return BinderBuilding::create($param);
    }

}
