<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager\LimitedContents;

use App\Consts\SessionConst;
use App\Http\Requests\Manager\Contents\BinderCategoryUpdateRequest;
use App\Http\Requests\Manager\Contents\BinderAddRequest;
use App\Models\BinderBuildingCategory;
use App\Models\Building;
use App\Services\BuilderService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BinderController extends Controller
{
    private BuilderService $binder_service;

    public function __construct()
    {
        $this->binder_service = app(BuilderService::class);
    }

    /**
     * @param Building $building
     * @return View
     */
    public function index(Building $building): View
    {
        $binder_building_category = $this->binder_service->getBinderBuildingCategory($building->id);
        $binder_building_category->load('binderBuilding');

        return view('manager.project.contents.limited_contents.binder', [
            'building' => $building,
            'binder_building_category' => $binder_building_category,
        ]);
    }

    /**
     * カテゴリの更新処理を行う
     * @param Building $building
     * @param BinderCategoryUpdateRequest $request
     * @return RedirectResponse
     */
    public function categoryUpdate(Building $building, BinderCategoryUpdateRequest $request): RedirectResponse
    {
        try {
            $this->binder_service->categoryUpdate($building->id, $request->all());
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['カテゴリを更新しました']);
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['カテゴリを更新処理に失敗しました']);
        }
    }

    /**
     * カテゴリの更新処理を行う
     * @param Building $building
     * @param BinderBuildingCategory $binder_building_category
     * @return RedirectResponse
     */
    public function destroy(Building $building, BinderBuildingCategory $binder_building_category): RedirectResponse
    {
        try {
            if ($building->id <> $binder_building_category->building_id) {
                return response()->json([
                    'status' => 'error',
                ]);
            }

            // 誰が削除したか
            $binder_building_category->delete();

            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['カテゴリを削除しました']);
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['カテゴリの削除処理に失敗しました']);
        }

    }

    /**
     */
    public function addBinder(Building $building, BinderAddRequest $request): RedirectResponse
    {
        try {
            $file_path = null;
            $thumbnail_path = null;
            if ($request->hasFile('pdf_file') && $request->file('pdf_file')->isValid()) {
                // 任意のディレクトリに保存（例: storage/app/public/binders/{buildingId}/）
                $file_path = $request['pdf_file']->store("{$building->id}/binder");
            }

            if ($request->hasFile('thumbnail_file') && $request->file('thumbnail_file')->isValid()) {
                $thumbnail_path = $request->file('thumbnail_file')->store("{$building->id}/thumbnails");
            }

            $this->binder_service->addBinder($building->id, $request->all(), $file_path, $thumbnail_path);

            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['資料を登録しました']);
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['資料の登録に失敗しました']);
        }
    }



}
