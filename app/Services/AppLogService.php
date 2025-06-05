<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AppLog;
use App\Repositories\Interfaces\AppLogRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AppLogService
{
    private AppLogRepositoryInterface $app_log_repository;

    public function __construct()
    {
        $this->app_log_repository = app(AppLogRepositoryInterface::class);
    }

    /**
     * 対象物件の総閲覧回数を取得する
     * @param array $building_ids
     * @return int
     */
    public function getTotalViewCountByBuildingIds(array $building_ids): int
    {
        return $this->app_log_repository->getTotalViewCountByBuildingIds($building_ids);
    }

    /**
     * 限定コンテンツの閲覧ログを作成する
     * @param array $param
     * @return AppLog
     */
    public function create(array $param): AppLog
    {
        return $this->app_log_repository->create($param);
    }
}
