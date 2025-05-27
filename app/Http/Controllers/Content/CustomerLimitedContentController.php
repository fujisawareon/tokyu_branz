<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Models\Building;

/**
 *
 */
class CustomerLimitedContentController extends LimitedContentController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke(Building $building, string $page_name)
    {
        $contents = [
            'top',
            '間取り',
        ];

        return view('limited_contents.top', [
            'building' => $building,
            'contents' => $contents,
        ]);
    }

}
