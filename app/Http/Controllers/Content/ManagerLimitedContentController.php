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
        $contents_menu = $this->getContentsMenu();
        $contents_data = $this->getPageData();

        return view('limited_contents.top', [
            'building' => $building,
            'contents_menu' => $contents_menu,
            'contents_data' => $contents_data,
        ]);
    }

}
