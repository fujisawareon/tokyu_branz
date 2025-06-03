<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager\LimitedContents;

use App\Consts\SessionConst;
use App\Models\Building;
use App\Services\ImageGalleryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ImageGalleryController extends Controller
{
    private ImageGalleryService $image_gallery_service;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->image_gallery_service = app(ImageGalleryService::class);
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

            // 元画像保存
            $request->file('image')->storeAs($directory, $file_name, 'public');

            // Intervention Image でサムネイル作成
            $manager = new ImageManager(new Driver());
            $thumbnail = $manager
                ->read($request->file('image')->getPathname())
                ->resize(300, null)
                ->toJpeg();

            // サムネイル保存
            Storage::disk('public')->put("{$directory}/thumbnail/{$file_name}", (string) $thumbnail);

            // 保存データ
            $this->image_gallery_service->create( [
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


    public function show($building, $filename)
    {
        $path = "{$building}/image_gallery/{$filename}";

        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('private')->get($path);
        $mime = Storage::disk('private')->mimeType($path);

        return response($file, 200)->header('Content-Type', $mime);
    }
}
