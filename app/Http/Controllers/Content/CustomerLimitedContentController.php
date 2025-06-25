<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Models\AppLog;
use App\Models\Building;
use App\Models\Customer;
use App\Services\AppLogService;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class CustomerLimitedContentController extends LimitedContentController
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

    public function __invoke(Building $building, string $page_name)
    {

        $this->setParam($building, $page_name);
        // 閲覧可能なメニューを取得
        $this->setContentsMenu();

        // 閲覧可能なメニューかチェックする
        if (!$this->checkURL()) {

        }

        // 閲覧画面に必要なデータを取得
        $this->setPageData($building, $page_name);

        // 閲覧ログを登録
        $app_log_id = NULL;
        if (!in_array($page_name, ['building_documents', 'plan'])) {
            $app_log =$this->app_log_service->create([
                'building_id' => $building->id,
                'customer_id' => $this->customer->id,
                'page_key' => $page_name,
            ]);
            $app_log_id = $app_log->id;
        }

        return view('limited_contents.' . $page_name,
            $this->passingVariables($app_log_id)
        );
    }

}
