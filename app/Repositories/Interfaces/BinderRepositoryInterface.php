<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\BinderBuilding;
use Illuminate\Database\Eloquent\Collection;

interface BinderRepositoryInterface
{
    /**
     * @param array $param
     */
    public function create(array $param): BinderBuilding;
}
