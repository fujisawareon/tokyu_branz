<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager;

use App\Consts\SessionConst;
use App\Http\Requests\Manager\BuildingCreateRequest;
use App\Http\Requests\Manager\BuildingUpdateRequest;
use App\Models\Building;
use App\Models\CustomerBuilding;
use App\Services\BuildingService;
use App\Services\BuildingSettingService;
use App\Traits\FormTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class BuildingController extends Controller
{
    use FormTrait;

    private BuildingService $building_service;
    private BuildingSettingService $building_setting_service;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->building_service = app(BuildingService::class);
        $this->building_setting_service = app(BuildingSettingService::class);
    }

    /**
     * 物件一覧画面を表示する
     * @param Request $request
     * @return View
     */
    public function index(): View
    {
        $status_list = $this->convertSelectArray(Building::SALES_STATUS, null, null, [
            'value' => null,
            'label' => '販売ステータスを選択してください',
        ]);

        return view('manager.building.list', [
            'status_list' => $status_list,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getBuildingList(Request $request)
    {
        $query = $this->building_service->makeBuildingGetQuery($request->all());

        return DataTables::of($query)
            ->addColumn('sales_status_name', function ($row) {
                return Building::SALES_STATUS[$row->sales_status] ?? '';
            })
            ->make();
    }

    /**
     * 物件登録画面を表示する
     * @return View
     */
    public function create(): View
    {
        $status_list = $this->convertSelectArray(Building::SALES_STATUS);

        return view('manager.building.create', [
            'status_list' => $status_list,
        ]);
    }

    /**
     * 物件登録確認画面を表示する
     * @param BuildingCreateRequest $request
     * @return View
     */
    public function createConfirm(BuildingCreateRequest $request): View
    {
        // ファイルはセッションに入れられないので、必要な情報だけ取得する
        $request_data = $request->all([
            'building_name',
            'building_8_digit_code',
            'building_4_digit_code',
            'contents_design_flg',
            'location',
            'nearest_station',
        ]);

        // ファイルを storage のtmpディレクトリに保存しておく
        if($request->contents_design_flg == 0){
            // TODO 画像用のサービスクラスを作成しておく事
            $top_image_file = $request->file('top_image');
            $top_image_file_name = 'top_image_' . time() . '_' . $top_image_file->getClientOriginalName(); // タイムスタンプ付きで保存
            $top_image_file->storeAs('tmp', $top_image_file_name, 'public');
            $request_data['top_image'] = $top_image_file_name;
        }

        // サムネイル画像の登録
        $thumbnail_image_file = $request->file('thumbnail_image');
        $thumbnail_image_file_name = 'thumbnail_image_' . time() . '_' . $thumbnail_image_file->getClientOriginalName(); // タイムスタンプ付きで保存
        $thumbnail_image_file->storeAs('tmp', $thumbnail_image_file_name, 'public');
        $request_data['thumbnail_image'] = $thumbnail_image_file_name;

        $token = Str::uuid(); // LaravelのStrヘルパーでユニークID生成
        $request_data['flow_token'] = $token;

        session()->put(SessionConst::BUILDING_CREATE_DATA . '_' . $token, $request_data);

        return view('manager.building.create-confirm', [
            'request' => $request_data,
        ]);
    }

    /**
     * 物件登録処理を行なう
     * @return RedirectResponse
     */
    public function register(FormRequest $request): RedirectResponse
    {
        $token = $request->input('flow_token');
        $request_data = session()->pull(SessionConst::BUILDING_CREATE_DATA . '_' . $token);

        // セッションが空の場合
        if (empty($request_data)) {
            return redirect()->route('manager_building_create')->with(SessionConst::FLASH_MESSAGE_ERROR, ['リクエストデータが不正です']);
        }

        try {
            $building = $this->building_service->store($request_data);

            // 画像の移動
            $old_path = 'tmp/';
            $new_path = 'building/' . $building->id . '/';
            if(isset($request_data['top_image'])) {
                Storage::move($old_path . $request_data['top_image'], $new_path . $request_data['top_image']);
            }
            Storage::move($old_path . $request_data['thumbnail_image'], $new_path . $request_data['thumbnail_image']);

            // 初期データの登録
            $this->building_setting_service->createDefaultBuildingSetting($building->id);

            return redirect()->route('manager_building_list')->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['物件を登録しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->route('manager_building_create')->with(SessionConst::FLASH_MESSAGE_ERROR, ['物件の登録処理に失敗しました']);
        }
    }

    /**
     * 物件基本情報設定画面を表示する
     * @param Building $building
     * @return View
     */
    public function basicSetting(Building $building): View
    {
        return view('manager.building.basic-setting', [
            'building' => $building,
        ]);
    }

    /**
     * 物件の基本情報を更新する
     * @param Building $building
     * @param BuildingUpdateRequest $request
     * @return RedirectResponse
     */
    public function basicSettingUpdate(Building $building, BuildingUpdateRequest $request): RedirectResponse
    {
        $this->building_service->update($building, $request->all());

        return redirect()->route('manager_building_basic_setting', ['building' => $building->id])
            ->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['物件を登録しました']);
    }
}
