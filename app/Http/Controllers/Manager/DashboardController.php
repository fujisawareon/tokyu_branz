<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Services\AppLogService;
use App\Services\BuildingService;
use App\Services\DashboardService;
use App\Traits\FormTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use FormTrait;

    private AppLogService $app_log_service;
    private BuildingService $building_service;
    private DashboardService $dashboard_service;

    public function __construct()
    {
        $this->building_service = app(BuildingService::class);
        $this->dashboard_service = app(DashboardService::class);
        $this->app_log_service = app(AppLogService::class);
    }

    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->isMethod('get')) { //GETメソッドの場合
            // 過去に選択していた値を取得
            $selected_building_ids = $this->dashboard_service->getSelectedBuildingIds();
        } else {
            // 選択した物件を保存
            $selected_building_ids = ($request->select_building) ?? [];
            $this->dashboard_service->updateSelectedBuildingIds($selected_building_ids);
        }

        $building_list = $this->building_service->getBuildings(); // 全物件のコレクション
        $selected_buildings = $building_list->whereIn('id', $selected_building_ids); // 選択中の物件のコレクション

        $total_view_count = $this->app_log_service->getTotalViewCountByBuildingIds($selected_building_ids);

        $horizontal_data = $this->makeHorizontalData();
        return view('manager.dashboard', [
            'building_list' => $this->convertSelectArray($building_list->all(), 'id', 'building_name'),
            'selected_building_ids' => $selected_building_ids,
            'selected_buildings' => $selected_buildings,
            'total_view_count' => $total_view_count,
            'horizontal_data' => $horizontal_data,
            'building_label' => $selected_buildings->pluck('building_name')->all(),
            'chart_data' => [75, 50, 5], // 物件別初回ログイン率
        ]);
    }


    public function makeHorizontalData()
    {
        return [
            'data' => [
                [
                    'title' => 'トップページ',
                    'value' => 1000,
                ], [
                    'title' => 'スケジュール',
                    'value' => 750,
                ], [
                    'title' => '画像ギャラリー',
                    'value' => 500,
                ], [
                    'title' => 'オンライン紹介動画',
                    'value' => 500,
                    'children' => [
                        [
                        'title' => '〇〇サポート動画',
                        'value' => 100,
                        ],
                    ],
                ], [
                    'title' => '物件資料集',
                    'value' => 250,
                    'children' => [
                        [
                            'title' => '資料-A',
                            'value' => 150,
                        ],
                        [
                            'title' => '資料-B',
                            'value' => 100,
                        ],
                    ],
                ], [
                    'title' => '画像ギャラリー',
                    'value' => 50,
                ]
            ],
            'max_value' => 1000,
        ];
    }
}
