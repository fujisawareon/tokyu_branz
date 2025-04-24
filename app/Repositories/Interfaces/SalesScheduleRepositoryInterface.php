<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\SalesSchedule;
use Illuminate\Database\Eloquent\Collection;

interface SalesScheduleRepositoryInterface
{
    /**
     * 販売スケジュールを取得する
     * @param int $building_id
     * @return Collection<int, SalesSchedule>
     */
    public function getSalesSchedule(int $building_id): Collection;

    /**
     * 対象物件の特定の販売スケジュールを取得
     * @param int $building_id
     * @param string $schedule_key
     * @return ?SalesSchedule
     */
    public function getByBuildingIdAndScheduleKey(int $building_id, string $schedule_key): ?SalesSchedule;

    /**
     * 販売スケジュールを登録する
     * @param array $record
     * @return mixed
     */
    public function create(array $record);

    /**
     * 対象物件の販売スケジュールを全て非表示にする
     * @param int $building_id
     */
    public function allHiddenByBuildingId(int $building_id): void;

    /**
     * 対象の販売スケジュールを更新する
     * @param SalesSchedule $sales_schedule
     * @param array $param
     */
    public function overwrite(SalesSchedule $sales_schedule, array $param);
}
