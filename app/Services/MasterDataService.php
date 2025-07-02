<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MasterData;
use App\Repositories\Interfaces\MasterDataRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MasterDataService
{
    private MasterDataRepositoryInterface $master_data_repository;

    public function __construct()
    {
        $this->master_data_repository = app(MasterDataRepositoryInterface::class);
    }

    /**
     * @return Collection<int, MasterData>
     */
    public function getMasterSalesScheduleData()
    {
        return $this->master_data_repository->getMasterDataByDataType(MasterData::SALES_SCHEDULE);
    }
}
