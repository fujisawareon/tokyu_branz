<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Manager\ManagerUpdateRequest;
use App\Models\Manager;
use App\Repositories\Interfaces\BuildingInvitationRepositoryInterface;
use App\Repositories\Interfaces\ManagerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ManagerService
{
    private BuildingInvitationRepositoryInterface $building_invitation_repository;
    private ManagerRepositoryInterface $manager_repository;

    public function __construct()
    {
        $this->building_invitation_repository = app(BuildingInvitationRepositoryInterface::class);
        $this->manager_repository = app(ManagerRepositoryInterface::class);
    }

    /**
     * @return LengthAwarePaginator<int, Manager>
     */
    public function getManagers(): LengthAwarePaginator
    {
        return $this->manager_repository->getManagers();
    }

    /**
     */
    public function update(Manager $manager, array $param)
    {
        return $this->manager_repository->update($manager, $param);
    }


    /**
     */
    public function createInvitation(int $manager_id, array $param)
    {
        $records = [];
        foreach ($param as  $building_id) {
            $records[] = [
                'manager_id' => $manager_id,
                'building_id' => $building_id,
                'created_by' => Auth::guard('managers')->user()->id,
            ];
        }

        $this->building_invitation_repository->create($records);
    }


}
