<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager\LimitedContents;

use App\Consts\SessionConst;
use App\Models\Building;
use App\Models\ImageGallery;
use App\Services\ImageGalleryService;
use App\Services\BuildingSettingService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // ← GDドライバを明示的に指定
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ImageGalleryController extends Controller
{
    private ImageGalleryService $image_gallery_service;
    private BuildingSettingService $building_setting_service;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->image_gallery_service = app(ImageGalleryService::class);
        $this->building_setting_service = app(BuildingSettingService::class);
    }

    /**
     * @param Building $building
     * @return View
     */
    public function index(Building $building): View
    {
        $image_gallery_list = $this->image_gallery_service->getByBuildingId($building->id);
        return view('manager.project.contents.limited_contents.image-gallery', [
            'building' => $building,
            'image_gallery_list' => $image_gallery_list,
        ]);
    }

    /**
     * @param Building $building
     * @param Request $request // TODO
     * @return RedirectResponse
     */
    public function addImage(Building $building, Request $request): RedirectResponse
    {
        try {
            // 入力値取得
            $title = $request->input('title', 'image');
            $randomStr = Str::random(8);
            $extension = $request->file('image')->getClientOriginalExtension();

            // ファイル名定義
            $file_name = "{$title}_{$randomStr}.{$extension}";

            // 保存ディレクトリ
            $directory = "{$building->id}/image_gallery";
            Storage::disk('public')->makeDirectory($directory);

            // 元画像を保存
            $request->file('image')->storeAs($directory, $file_name, 'public');

            // 保存先フルパス（物理パス）
            $storagePath = Storage::disk('public')->path("{$directory}/{$file_name}");

            // Intervention で読み込む
            $manager = new ImageManager(new Driver());
            $thumbnail = $manager->read($storagePath)
                ->scale(width: 300, height: null); // 高さ省略NGの可能性

            // 拡張子別に変換
            $thumbnail = match ($extension) {
                'png' => $thumbnail->toPng(),
                'webp' => $thumbnail->toWebp(),
                default => $thumbnail->toJpeg(),
            };

            // サムネイル保存
            Storage::disk('public')->put("{$directory}/thumbnail/{$file_name}", (string) $thumbnail);

            // 保存データ
            $this->image_gallery_service->create([
                'building_id' => $building->id,
                'title' => $request->title,
                'image_file_name' => $file_name,
            ]);

            return redirect()->route('manager_project_image_gallery', [
                'building' => $building->id,
            ])->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['画像ギャラリーを登録しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->route('manager_project_image_gallery', [
                'building' => $building->id,
            ])->with(SessionConst::FLASH_MESSAGE_ERROR, ['画像ギャラリーの登録処理に失敗しました']);
        }
    }

    /**
     * @param Building $building
     * @param Request $request // TODO
     */
    public function update(Building $building, Request $request)
    {
        try {
            // 注釈文を更新
            $this->building_setting_service->upsertBuildingSetting($building, [
                'image_gallery_annotation' => $request->image_gallery_annotation,
            ]);

            // TODO 画像のタイトルと並び順を更新

            return redirect()->route('manager_project_image_gallery', [
                'building' => $building->id,
            ])->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['画像ギャラリー設定を更新しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['画像ギャラリー設定の更新処理に失敗しました']);
        }
    }

    /**
     * 画像ギャラリーを削除する
     * @param Building $building
     * @param ImageGallery $image_gallery
     * @return void
     */
    public function delete(Building $building, ImageGallery $image_gallery)
    {
        if ($building->id <> $image_gallery->building_id) {
            // TODO
            dd('不正なリクエストです');
        }
        $image_gallery->updated_by = Auth::guard('managers')->user()->id;
        $image_gallery->deleted_at = Carbon::now();
        $image_gallery->save();
    }
}
