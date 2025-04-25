<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager;

use App\Consts\SessionConst;
use App\Http\Requests\Manager\Contents\ActionBtnSettingUpdateRequest;
use App\Http\Requests\Manager\Contents\LimitedContentsUpdateRequest;
use App\Http\Requests\Manager\Contents\SalesStatusUpdateRequest;
use App\Http\Requests\Manager\Contents\SalesScheduleUpdateRequest;
use App\Models\Building;
use App\Models\CustomerBuilding;
use App\Services\BuildingService;
use App\Services\BuildingSettingService;
use App\Services\LimitedContentsShareService;
use App\Traits\FormTrait;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class ProjectContentsController extends Controller
{
    use FormTrait;

    private BuildingService $building_service;
    private BuildingSettingService $building_setting_service;
    private LimitedContentsShareService $limited_contents_share_service;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->building_service = app(BuildingService::class);
        $this->building_setting_service = app(BuildingSettingService::class);
        $this->limited_contents_share_service = app(LimitedContentsShareService::class);
    }

    /**
     * コンテンツ管理一覧画面を表示する
     * @param Building $building
     * @return View
     */
    public function index(Building $building): View
    {
        return view('manager.project.contents.list', [
            'building' => $building,
        ]);
    }

    /**
     * 販売ステータス設定画面を表示する
     * @param Building $building
     * @return View
     */
    public function salesStatus(Building $building): View
    {
        $status_list = $this->convertSelectArray(Building::SALES_STATUS);
        $building->load('buildingSetting');

        return view('manager.project.contents.sales-status', [
            'building' => $building,
            'sales_status' => $status_list,
        ]);
    }

    /**
     * 販売ステータスの更新処理
     * @param Building $building
     * @param SalesStatusUpdateRequest $request
     * @return RedirectResponse
     */
    public function salesStatusUpdate(Building $building, SalesStatusUpdateRequest $request): RedirectResponse
    {
        try {
            // 販売ステータスを更新
            $this->building_service->update($building, [
                'sales_status' => $request->sales_status,
            ]);

            if ($request->sales_status <> Building::SALES_STATUS_ON_SALE) {
                // 販売中止時のメッセージを更新
                $this->building_setting_service->upsertBuildingSetting($building, [
                    'sales_suspension_title' => $request->title,
                    'sales_suspension_message' => $request->message,
                ]);
            }

            return redirect()->route('manager_project_sales_status', ['building' => $building->id])
                ->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['販売ステータスを更新しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['販売ステータスの更新に失敗しました']);
        }
    }

    /**
     * 販売スケジュール設定画面を表示する
     * @param Building $building
     * @return View
     */
    public function salesSchedule(Building $building): View
    {
        $sales_schedule_list = $this->building_setting_service->getSalesScheduleList($building->id);

        return view('manager.project.contents.sales-schedule', [
            'building' => $building,
            'sales_schedules' => $sales_schedule_list,
        ]);
    }

    /**
     * 販売スケジュールを更新する
     * @param Building $building
     * @param SalesScheduleUpdateRequest $request
     * @return RedirectResponse
     */
    public function salesScheduleUpdate(Building $building, SalesScheduleUpdateRequest $request): RedirectResponse
    {
        try {
            $records = [];
            $sort = 1;
            foreach ($request->sales_schedule_key as $schedule_key) {
                $record = [];
                $record['building_id'] = $building->id;
                $record['schedule_key'] = $schedule_key;
                $record['sort'] = $sort;
                $record['display_flg'] = (isset($request->display[$schedule_key])) ? 1 : 0;
                $record['created_by'] = (isset($request->display[$schedule_key])) ? 1 : 0;

                $records[] = $record;
                $sort++;
            }

            $this->building_setting_service->upsertSalesSchedule($building->id, $records);
            return redirect()->route('manager_project_sales_schedule', ['building' => $building->id])
                ->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['販売スケジュールを更新しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['販売スケジュールの更新に失敗しました']);
        }
    }

    /**
     * アクションボタン設定画面を表示する
     * @param Building $building
     * @return View
     */
    public function actionBtn(Building $building): View
    {
        $building->load([
            'buildingSetting',
            'actionBtnSetting',
        ]);

        return view('manager.project.contents.action-btn', [
            'building' => $building,
            'max_action_btn_id' => $building->actionBtnSetting->max('id'),
        ]);
    }

    /**
     * アクションボタン設定を更新する
     * @param Building $building
     * @param ActionBtnSettingUpdateRequest $request
     * @return RedirectResponse
     */
    public function actionBtnUpdate(Building $building, ActionBtnSettingUpdateRequest $request): RedirectResponse
    {

        try {
            // 物件サイトの更新
            $this->building_setting_service->upsertBuildingSetting($building, [
                'building_site_url' => $request->building_site_url ?? '',
                'building_site_display_flg' => $request->building_site_display_flg ?? 0,
            ]);

            // アクションボタンの更新
            $this->building_setting_service->updateActionBtnSetting($building, $request->all());

            return redirect()->route('manager_project_action_btn', ['building' => $building->id])
                ->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['アクションボタン設定を更新しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['アクションボタン設定の更新に失敗しました']);
        }
    }

    /**
     * 限定コンテンツ設定画面を表示する
     * @param Building $building
     * @return View
     */
    public function limitedContent(Building $building): View
    {
        $limited_content_list = $this->building_setting_service->getLimitedContentList($building->id);
        return view('manager.project.contents.limited-content', [
            'building' => $building,
            'limited_content_list' => $limited_content_list,
        ]);
    }

    /**
     * 限定コンテンツの表示順を更新する
     * @param Building $building
     * @param LimitedContentsUpdateRequest $request
     * @return RedirectResponse
     */
    public function limitedContentUpdate(Building $building, LimitedContentsUpdateRequest $request): RedirectResponse
    {
        try {
            $records = [];
            $sort = 1;
            foreach ($request->limited_content as $limited_content) {
                $records[] = [
                    'building_id' => $building->id,
                    'data_key' => $limited_content,
                    'sort' => $sort,
                    'display_flg' => isset($request->display[$limited_content]) ? 1 : 0,
                ];

                $sort++;
            }

            $this->building_setting_service->upsertLimitedContent($building->id, $records);
            return redirect()->route('manager_project_limited_content', ['building' => $building->id])
                ->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['限定コンテンツ設定を更新しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['限定コンテンツ設定の更新に失敗しました']);
        }

    }

    /**
     * シェア内容設定画面を表示する
     * @param Building $building
     * @return View
     */
    public function shareContent(Building $building): View
    {
        $status_list = CustomerBuilding::STATUS_LIST;
        unset($status_list[CustomerBuilding::STATUS_DISCUSSION_DISCONTINUED]); // 検討中止を除外する
        $status_keys = array_keys($status_list);
        $status_list = $this->convertSelectArray($status_list);

        // 現在選択中のステータス
        $selected_status = request()->query('status') ?? CustomerBuilding::STATUS_ENTRY;

        if (!in_array($selected_status, $status_keys)) {
            dd('選択不可能な値の場合のエラー処理を作成する'); // TODO 選択不可能な値の場合はエラー
        }

        // コンテンツ
        $limited_content_list = $this->building_setting_service->getLimitedContentList($building->id);
        $share_contents_list = $this->limited_contents_share_service->getShareContentsList($building->id, (int)$selected_status)
            ->pluck('content_key')->all();

        // 間取り
        // 物件資料集
        // アクションボタン

        return view('manager.project.contents.share-content', [
            'building' => $building,
            'status_list' => $status_list,
            'selected_status' => $selected_status,
            'limited_content_list' => $limited_content_list,
            'share_contents_list' => $share_contents_list,
        ]);
    }

    /**
     * シェア内容を更新する
     * @param Building $building
     * @param FormRequest $request // TODO
     * @return RedirectResponse
     */
    public function shareContentUpdate(Building $building, FormRequest $request): RedirectResponse
    {
        $manager_id = Auth::guard('managers')->user()->id;
        $status_id = (int)$request->status;

        try {
            // コンテンツのシェア内容を一度削除
            $this->limited_contents_share_service->deleteShareContentsList($building->id, $status_id, $manager_id);

            // コンテンツのシェア内容を再登録
            if ($request->contents) {
                $this->limited_contents_share_service->insertShareContentsList($building->id, $status_id, $manager_id, $request->contents);
            }

            return redirect()->route('manager_project_share_content', ['building' => $building->id, 'status' => $status_id])
                ->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['シェア内容を更新しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['シェア内容の更新に失敗しました']);
        }
    }
}
