<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager;

use App\Consts\SessionConst;
use App\Http\Requests\Manager\ManagerUpdateRequest;
use App\Models\BuildingInvitation;
use App\Models\Manager;
use App\Services\BuildingService;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\ManagerService;
use App\Traits\FormTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ManagerController extends Controller
{
    use FormTrait;

    private BuildingService $building_service;
    private ManagerService $manager_service;

    /**
     * コンストラクタ
     */
    public function __construct ()
    {
        $this->building_service = app(BuildingService::class);
        $this->manager_service = app(ManagerService::class);
    }

    /**
     * 業務ユーザー一覧画面を表示する
     * @return View
     */
    public function list(): View
    {
        $manager_list = $this->manager_service->getManagers();

        $role_list = $this->convertSelectArray(Manager::ROLE_TYPE_LIST, null, null, [
            'value' => null,
            'label' => '権限を選択してください',
        ]);

        return view('manager.user.list', [
            'manager_list' => $manager_list,
            'role_list' => $role_list,
        ]);
    }

    /**
     * @param Manager $manager
     * @return View
     */
    public function show(Manager $manager): View
    {
        $manager->load('invitationBuilding.building');
        $selected_building_ids = $manager->invitationBuilding->pluck('building_id')->All();

        $building_role_list = $this->convertSelectArray(BuildingInvitation::ROLE_TYPE_LIST);
        $role_list = $this->convertSelectArray(Manager::ROLE_TYPE_LIST);
        $all_building_list = $this->building_service->getBuildings();

        $all_building_list = $all_building_list->reject(function ($item) use($selected_building_ids) {
            return in_array($item['id'], $selected_building_ids) ;
        });

        return view('manager.user.show', [
            'manager' => $manager,
            'role_list' => $role_list,
            'building_role_list' => $building_role_list,
            'all_building_list' => $this->convertSelectArray($all_building_list->All(), 'id', 'building_name'),
        ]);
    }

    /**
     * @param Manager $manager
     * @param ManagerUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(Manager $manager, ManagerUpdateRequest $request)
    {
        try {
            $this->manager_service->update($manager, $request->all());

            return redirect()->route('manager_user_show', ['manager' => $manager->id])
                ->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['基本情報を更新しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['基本情報の更新に失敗しました']);
        }
    }

    /**
     * @param Manager $manager
     * @param FormRequest $request TODO バリデーションが必要
     * @return RedirectResponse
     */
    public function invitation(Manager $manager, FormRequest $request): RedirectResponse
    {
        try {
            $this->manager_service->createInvitation($manager->id, $request->select_building);

            return redirect()->route('manager_user_show', ['manager' => $manager->id])->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['物件への招待が完了しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->route('manager_user_show', ['manager' => $manager->id])->with(SessionConst::FLASH_MESSAGE_ERROR, ['物件への招待に失敗しました']);
        }
    }



}
