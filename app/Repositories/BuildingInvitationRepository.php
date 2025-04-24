<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AppLog;
use App\Models\Building;
use App\Models\BuildingInvitation;
use App\Repositories\Interfaces\BuildingInvitationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BuildingInvitationRepository implements BuildingInvitationRepositoryInterface
{
    /**
     * @inheritDoc
     * @see BuildingInvitationRepositoryInterface::create()
     */
    public function create(array $records)
    {
        return BuildingInvitation::insert($records);
    }
}
