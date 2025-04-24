<?php

declare(strict_types=1);

namespace App\Services;

use App\Consts\CommonConsts;
use App\Models\Building;
use App\Models\BuildingSetting;
use App\Models\Manager;
use App\Models\MasterData;
use App\Repositories\Interfaces\BuildingStatusRepositoryInterface;
use App\Repositories\Interfaces\LimitedContentRepositoryInterface;
use App\Repositories\Interfaces\MasterDataRepositoryInterface;
use App\Repositories\Interfaces\SalesScheduleRepositoryInterface;
use App\Traits\CacheTrait;
use Illuminate\Support\Facades\Auth;

class BuildingSettingService
{
    use CacheTrait;

    private BuildingStatusRepositoryInterface $building_status_repository;
    private LimitedContentRepositoryInterface $limited_content_repository;
    private MasterDataRepositoryInterface $master_data_repository;
    private SalesScheduleRepositoryInterface $sales_schedule_repository;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->building_status_repository = app(BuildingStatusRepositoryInterface::class);
        $this->limited_content_repository = app(LimitedContentRepositoryInterface::class);
        $this->master_data_repository = app(MasterDataRepositoryInterface::class);
        $this->sales_schedule_repository = app(SalesScheduleRepositoryInterface::class);
    }

    /**
     * 物件設定情報の初期登録を行う
     * @param int $building_id
     */
    public function createDefaultBuildingSetting(int $building_id): void
    {
        $this->building_status_repository->createDefault($building_id);
    }

    /**
     * 物件設定情報の更新を行う
     * ※無ければ作成する
     * @param Building $building
     * @param array $param
     * @return BuildingSetting|bool
     */
    public function updateSalesSuspensionMessage(Building $building, array $param): bool|BuildingSetting
    {
        $building_setting = $building->buildingSetting;

        // 既にレコードがあれば更新処理
        if ($building_setting) {
            $param['updated_by'] = Auth::guard('managers')->user()->id;
            return $this->building_status_repository->update($building_setting, $param);
        }

        // 登録処理
        $param['building_id'] = $building->id;
        $param['created_by'] = Auth::guard('managers')->user()->id;
        return $this->building_status_repository->create($param);
    }

    /**
     * 販売スケジュールを取得する
     * @param int $building_id
     * @return array
     */
    public function getSalesScheduleList(int $building_id): array
    {
        // 設定済みの販売スケジュールを取得
        $sales_schedule_collection = $this->sales_schedule_repository->getSalesSchedule($building_id);

        // 販売スケジュールのマスタを取得
        $master_sales_schedules_collect = $this->master_data_repository->getMasterDataByDataType(MasterData::SALES_SCHEDULE);
        $master_sales_schedules = $master_sales_schedules_collect->pluck('name', 'data_key')->toArray();

        $sales_schedules = [];
        // 登録してあるデータを形成する
        foreach ($sales_schedule_collection as $sales_schedule) {
            if (isset($master_sales_schedules[$sales_schedule->schedule_key])) {
                $sales_schedules[] = [
                    'key' => $sales_schedule->schedule_key,
                    'schedule_name' => $master_sales_schedules[$sales_schedule->schedule_key],
                    'display' => $sales_schedule->display_flg,
                ];
            }
        }

        // 登録してないデータがあれば追加する
        $register_ids = $sales_schedule_collection->pluck('schedule_key')->all();
        foreach ($master_sales_schedules as $sales_schedule_key => $master_sales_schedule) {
            if (!in_array($sales_schedule_key, $register_ids)) {
                $sales_schedules[] = [
                    'key' => $sales_schedule_key,
                    'schedule_name' => $master_sales_schedule,
                    'display' => 0,
                ];
            }
        }

        return $sales_schedules;
    }

    /**
     * 販売スケジュールを更新する
     * @param int $building_id
     * @param array $records
     */
    public function upsertSalesSchedule(int $building_id, array $records): void
    {
        // 一度全て非表示にする
        $this->sales_schedule_repository->allHiddenByBuildingId($building_id);

        /** @var Manager $auth */
        $auth_user = Auth::guard('managers')->user();

        foreach ($records as $record) {
            // 既存のデータを取得
            $sales_schedule = $this->sales_schedule_repository->getByBuildingIdAndScheduleKey($building_id, $record['schedule_key']);

            // データがあれば更新
            if ($sales_schedule) {
                $this->sales_schedule_repository->overwrite($sales_schedule, [
                    'display_flg' => $record['display_flg'],
                    'sort' => $record['sort'],
                    'updated_by' => $auth_user->id,
                ]);
            } else {
                // データがないので登録
                $record['created_by'] = $auth_user->id;
                $this->sales_schedule_repository->create($record);
            }
        }
    }

    /**
     * 対象物件の限定コンテンツを取得する
     * @param int $building_id
     * @return array
     */
    public function getLimitedContentList(int $building_id): array
    {
        // 限定コンテンツのマスタを取得
        $master_data_collection = $this->master_data_repository->getMasterDataByDataType(MasterData::LIMITED_CONTENT);

        // 登録してあるデータを取得
        $limited_content_collection = $this->limited_content_repository->getByBuildingId($building_id);

        // 登録してあるデータを形成する
        $array = [];
        foreach ($limited_content_collection as $limited_content) {
            $array[] = [
                'key' => $limited_content['data_key'],
                'name' => $master_data_collection->where('data_key', $limited_content['data_key'])->first()->name,
                'display_flg' => $limited_content['display_flg'],
            ];
        }

        $register_ids = $limited_content_collection->pluck('data_key')->all();

        // 登録してないデータがあれば追加する
        foreach ($master_data_collection as $master_data) {
            if (!in_array($master_data->data_key, $register_ids)) {
                $array[] = [
                    'key' => $master_data['data_key'],
                    'name' => $master_data['name'],
                    'display_flg' => 0,
                ];
            }
        }

        return $array;
    }

    /**
     * 限定コンテンツ設定を更新する
     * @param int $building_id
     * @param array $records
     * @return void
     */
    public function upsertLimitedContent(int $building_id, array $records): void
    {
        /** @var Manager $auth */
        $auth_user = Auth::guard('managers')->user();

        // 既存のデータを取得
        $limited_contents = $this->limited_content_repository->getByBuildingId($building_id);

        foreach ($records as $record) {
            $limited_content = $limited_contents->where('data_key', $record['data_key'])->first();
            // データがあれば更新
            if ($limited_content) {
                $this->limited_content_repository->overwrite($limited_content, $record);
            } else {
                // データがないので登録
                $record['created_by'] = $auth_user->id;
                $this->limited_content_repository->create($record);
            }
        }
    }
}
