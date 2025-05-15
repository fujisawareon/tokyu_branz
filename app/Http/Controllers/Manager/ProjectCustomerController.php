<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager;

use App\Consts\SessionConst;
use App\Http\Requests\Manager\CustomerCreateRequest;
use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Customer;
use App\Models\CustomerBuilding;
use App\Models\Manager;
use App\Services\CustomerService;
use App\Services\CustomerAnalysisService;
use App\Traits\FormTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class ProjectCustomerController extends Controller
{
    use FormTrait;

    /** @var CustomerService $customer_service */
    private CustomerService $customer_service;

    /** @var CustomerAnalysisService $customer_analysis_service */
    private CustomerAnalysisService $customer_analysis_service;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->customer_service = app(CustomerService::class);
        $this->customer_analysis_service = app(CustomerAnalysisService::class);
    }

    /**
     * 顧客分析画面を表示する
     * @param Building $building
     * @return View
     */
    public function index(Building $building): View
    {
        /** @var Manager $manager */
        $manager = Auth::guard('managers')->user();

        // 担当者を取得
        $person_list = $this->convertCollectionToSelectArray($building->personCharge, 'id', 'name');

        $relation_status_list = $this->convertSelectArray(CustomerBuilding::RELATION_STATUS_LIST);
        $status_list = $this->convertSelectArray(CustomerBuilding::STATUS_LIST);

        // 顧客一覧に表示する項目
        $display_customer_list_columns = $this->customer_analysis_service->getByBuildingId($building->id, $manager->role_type <= Manager::ROLE_TYPE_EMPLOYEE);
        return view('manager.project.customer.analysis', [
            'building' => $building,
            'manager' => $manager,
            'person_list' => $person_list,
            'display_customer_list_columns' => $display_customer_list_columns,
            'checkbox' => [['value' => '1', 'label' => '',]],
            'relation_status_list' => $relation_status_list,
            'status_list' => $status_list,
        ]);
    }

    /**
     * 顧客一覧で表示する項目を更新する
     * @param Building $building
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateDisplayColumn(Building $building, Request $request): RedirectResponse
    {
        /** @var Manager $manager */
        $manager = Auth::guard('managers')->user();
        try {
            // 一度削除
            $this->customer_analysis_service->delete($building->id, $manager);

            // 再登録
            $this->customer_analysis_service->insert($building->id, $request->display);

            return redirect()->route('manager_project_customer', ['building' => $building->id])->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['項目表示を更新しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['項目表示の更新に失敗しました']);
        }
    }

    /**
     * 顧客登録画面を表示する
     * @param Building $building
     * @return View
     */
    public function create(Building $building): View
    {
        return view('manager.project.customer.create', [
            'building' => $building,
        ]);
    }

    /**
     * 顧客の登録を行なう
     * @param Building $building
     * @param CustomerCreateRequest $request
     * @return RedirectResponse
     */
    public function register(Building $building, CustomerCreateRequest $request): RedirectResponse
    {
        // TODO 顧客が既に存在するかや、存在する場合に既にリレーションされているかの処理が必要
        try {
            $password = Hash::make('password');
            $param = $request->all();
            $param['password'] = $password;

            $customer = $this->customer_service->createCustomer($param);
            $this->customer_service->createCustomerBuildingRelation($customer->id, $building->id);

            return redirect()->route('manager_project_customer', ['building' => $building->id])->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['顧客を登録しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['顧客の登録に失敗しました']);
        }
    }

    /**
     * 顧客基本情報編集画面を表示する
     * @param Building $building
     * @param Customer $customer
     * @return View
     */
    public function show(Building $building, Customer $customer): View
    {
        $person_charge = $building->personCharge;
        $customer_building = $customer->customerBuildingForBuilding($building->id)->firstOrFail();

        return view('manager.project.customer.show', [
            'building' => $building,
            'customer' => $customer,
            'customer_status' => [],
            'person_charge_list' => $this->convertCollectionToSelectArray($person_charge, 'id', 'name'),
            'customer_building' => $customer_building,
        ]);
    }

    /**
     * 「顧客分析」画面の「顧客一覧表」に表示する顧客リストを返却する
     * @param Building $building
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function getCustomerList(Building $building, Request $request): JsonResponse
    {
        $query = $this->customer_service->makeCustomerListQuery($building->id, $request->all());

        return DataTables::of($query)
            ->addColumn('status_label', function ($row) {
                return CustomerBuilding::RELATION_STATUS_LIST[$row->relation_status];
            })
            ->addColumn('customer_status_label', function ($row) {
                return CustomerBuilding::STATUS_LIST[$row->customer_status] ?? '';
            })
            ->make();
    }

    /**
     * 「顧客分析」画面の「顧客別アクセス分析一覧表」に表示する顧客リストを返却する
     * @param Building $building
     * @param Request $request
     * @return JsonResponse
     */
    public function getCustomerAccessAnalysisList(Building $building, Request $request): JsonResponse
    {
        $query = $this->customer_service->makeCustomerAccessAnalysisQuery($building->id, $request->all());

        return DataTables::of($query)
            ->addColumn('status_label', function ($row) {
                return CustomerBuilding::RELATION_STATUS_LIST[$row->relation_status];
            })
            ->addColumn('customer_status_label', function ($row) {
                return CustomerBuilding::STATUS_LIST[$row->customer_status] ?? '';
            })
            ->make();
    }

    /**
     * TODO メソッド名を修正する事
     * @param Building $building
     * @param Customer $customer
     * @return void
     */
    public function test(Building $building, Customer $customer): void
    {
        $this->customer_service->togglePin($building->id, $customer->id);
    }
}
