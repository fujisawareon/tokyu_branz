<?php

declare(strict_types=1);

namespace App\Consts;

class CacheConsts
{
    public const KEY_NAME_TYPE_SELECTED_BUILDING = 1;
    public const KEY_NAME_TYPE_MASTER_DATA = 2;

    public const USER_SELECTED_BUILDING_IDS = 'user_selected_building_%d';
    public const MASTER_DATA = 'master_data_type_%d';
}
