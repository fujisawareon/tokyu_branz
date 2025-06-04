<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Models\Building;

/**
 *
 */
class ManagerLimitedContentController extends LimitedContentController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke(Building $building, string $page_name)
    {
        // 閲覧可能なメニューを取得
        $contents_menu = $this->getContentsMenu($building->id, true);

        // 閲覧可能なメニューかチェックする
        if (!$this->checkURL($page_name, $contents_menu)) {

        }

        // 閲覧画面に必要なデータを取得
        $contents_data = $this->getPageData($building->id, $page_name, true);

        return view('limited_contents.' . $page_name, [
            'building' => $building,
            'contents_menu' => $contents_menu,
            'contents_data' => $contents_data,
        ]);
    }

}
