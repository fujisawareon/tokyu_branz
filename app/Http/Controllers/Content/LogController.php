<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Models\AppLog;
use App\Models\Building;
use App\Models\Customer;
use App\Services\AppLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class LogController extends LimitedContentController
{
    /** @var Customer $customer */
    private Customer $customer;

    /** @var AppLogService $app_log_service */
    private AppLogService $app_log_service;

    public function __construct()
    {
        parent::__construct();
        $this->customer = Auth::guard('customers')->user();
        $this->app_log_service = app(AppLogService::class);
    }

    /**
     * @param Building $building
     * @param Request $request
     * @return JsonResponse
     */
    public function createLog(Building $building, Request $request): JsonResponse
    {
        $app_log = $this->app_log_service->create([
            'building_id' => $building->id,
            'customer_id' => $this->customer->id,
            'page_key' => $request->input('page_key'),
            'binder_building_id' => $request->input('binder_id'),
        ]);

        return response()->json([
            'status' => 'success',
            'app_log_id' => $app_log->id,
        ]);
    }

    public function updateStayTime(Building $building, AppLog $app_log)
    {
        $customer_id = $this->customer->id;
        $created_at = $app_log->created_at;
        $now = Carbon::now();

        // 滞在時間を計算
        $diffInSeconds = (int)$created_at->diffInSeconds($now);
        $formatted = gmdate('H:i:s', $diffInSeconds); // ※gmdateを使うことでUTCズレ対策になる

        // モデルに保存
        $app_log->stay_time = $formatted;
        $app_log->save();

        // 仮のレスポンスデータ
        return response()->json([
            'status' => 'success',
            'building_id' => $building->id,
            'stay_seconds' => $diffInSeconds,
            'message' => '滞在ログを受け取りました。 ' . $this->customer->id
        ]);
    }

}
