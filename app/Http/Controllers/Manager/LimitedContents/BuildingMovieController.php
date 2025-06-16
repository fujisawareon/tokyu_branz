<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager\LimitedContents;

use App\Consts\SessionConst;
use App\Http\Requests\Manager\Contents\AddMovieRequest;
use App\Models\Building;
use App\Services\MovieService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;
use Illuminate\Support\Facades\Http;


class BuildingMovieController extends Controller
{
    private MovieService $movie_service;

    public function __construct()
    {
        $this->movie_service = app(MovieService::class);
    }

    /**
     * @param Building $building
     * @param int $movie_type
     * @return View
     */
    public function index(Building $building, int $movie_type): View
    {
        $this->checkMovieType($movie_type);
        $movie_list = $this->movie_service->getMovieList($building->id, $movie_type);

        return view('manager.project.contents.limited_contents.building-movie', [
            'movie_type' => $movie_type,
            'building' => $building,
            'movie_list' => $movie_list,
            'view_title' => $this->getViewTitle($movie_type),
        ]);
    }

    /**
     * @param int $movie_type
     * @return string
     */
    private function getViewTitle(int $movie_type): string
    {
         return match ($movie_type) {
             1 => '物件紹介動画',
             2 => 'マンション購入の基礎知識編動画',
             3 => 'BRANZの管理と購入後のサポート編動画',
             default => '',
        };
    }

    /**
     * @param Building $building
     * @param int $movie_type
     * @param AddMovieRequest $request
     * @return RedirectResponse
     */
    public function addMovie(Building $building, int $movie_type, AddMovieRequest $request): RedirectResponse
    {
        try {
            $this->movie_service->addMovie([
                'building_id' => $building->id,
                'movie_category_id' => $request->movie_category_id,
                'title' => $request->title,
                'url' => $request->url,
                'vimeo_id' => $request->vimeo_id,
            ]);

            return redirect()->route('manager_project_building_movie', [
                'building' => $building->id,
                'movie_type' => $movie_type,
            ])->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['動画を登録しました']);
        } catch (Throwable $e) {
            Log::error($e->getMessage() . ' CLASS:' . __CLASS__ . ' ' . 'LINE:' . __LINE__);
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['動画の登録に失敗しました']);
        }
    }

    /**
     * @param int $movie_type
     * @return void
     */
    private function checkMovieType(int $movie_type): void
    {
        if (!in_array($movie_type, [1, 2, 3], true)) {
            abort(404);
        }
    }
}
