<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Manager\ManagerUpdateRequest;
use App\Models\Manager;
use App\Models\MasterData;
use App\Repositories\Interfaces\BuildingInvitationRepositoryInterface;
use App\Repositories\Interfaces\ManagerRepositoryInterface;
use App\Repositories\Interfaces\MasterDataRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MasterDataService
{
    private MasterDataRepositoryInterface $master_data_repository;

    public function __construct()
    {
        $this->master_data_repository = app(MasterDataRepositoryInterface::class);
    }

    /**
     */
    public function getMasterSalesScheduleData()
    {
        return $this->master_data_repository->getMasterDataByDataType(MasterData::SALES_SCHEDULE);
    }

}
