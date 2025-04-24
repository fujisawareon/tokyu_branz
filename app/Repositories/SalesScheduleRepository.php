<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SalesSchedule;
use App\Repositories\Interfaces\SalesScheduleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SalesScheduleRepository implements SalesScheduleRepositoryInterface
{
    /**
     * @inheritDoc
     * @see SalesScheduleRepositoryInterface::getSalesSchedule()
     */
    public function getSalesSchedule(int $building_id): Collection
    {
        return SalesSchedule::where('building_id', $building_id)
            ->orderBy('sort')->get();
    }

    /**
     * @inheritDoc
     * @see SalesScheduleRepositoryInterface::getByBuildingIdAndScheduleKey()
     */
    public function getByBuildingIdAndScheduleKey(int $building_id, string $schedule_key): ?SalesSchedule
    {
        return SalesSchedule::where('building_id', $building_id)
            ->where('schedule_key', $schedule_key)
            ->first();
    }

    /**
     * @inheritDoc
     * @see SalesScheduleRepositoryInterface::create()
     */
    public function create(array $record)
    {
        return SalesSchedule::create($record);
    }

    /**
     * @inheritDoc
     * @see SalesScheduleRepositoryInterface::allHiddenByBuildingId()
     */
    public function allHiddenByBuildingId(int $building_id): void
    {
        SalesSchedule::where('building_id', $building_id)->update(['display_flg' => 0]);
    }

    /**
     * @inheritDoc
     * @see SalesScheduleRepositoryInterface::overwrite()
     */
    public function overwrite(SalesSchedule $sales_schedule, array $param): void
    {
        $sales_schedule->fill($param)->save();
    }

}
