<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BuildingInvitationRepositoryInterface
{
    /**
     */
    public function create(array $records);

}
