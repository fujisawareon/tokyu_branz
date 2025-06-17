<?php

declare(strict_types=1);

namespace App\Consts;

class CommonConsts
{
    public const STATUS_TYPE = [
        0 => [
            'value' => 0,
            'label' => '無効',
        ],
        1 => [
            'value' => 1,
            'label' => '有効',
        ],
    ];
    public const PRESENCE_STATUS = [
        0 => [
            'value' => 0,
            'label' => 'なし',
        ],
        1 => [
            'value' => 1,
            'label' => 'あり',
        ],
    ];
    public const SETTING_TYPE = [
        0 => [
            'value' => 0,
            'label' => '設定しない',
        ],
        1 => [
            'value' => 1,
            'label' => '設定する',
        ],
    ];

    public const CUSTOM_TYPE = [
        0 => [
            'value' => 0,
            'label' => 'デフォルト',
        ],
        1 => [
            'value' => 1,
            'label' => 'カスタム',
        ],
    ];

    public const BINDER_FILE_TYPE = [
        0 => [
            'value' => 0,
            'label' => 'ファイル',
        ],
        1 => [
            'value' => 1,
            'label' => 'URL',
        ],
    ];

    public const OPTION_CONTENTS = [
        'private_area_vr',
        'plan_view_simulation',
        'shadow_simulation',
        'common_area_vr',
        'furniture_layout_simulation',
    ];
}


