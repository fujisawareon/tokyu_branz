<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\BuildingStatusRepositoryInterface;
use App\Models\BuildingSetting;
use Illuminate\Support\Facades\Auth;

class BuildingStatusRepository implements BuildingStatusRepositoryInterface
{
    /**
     * @inheritDoc
     * @see BuildingStatusRepositoryInterface::find()
     */
    public function find(int $building_id): ?BuildingSetting
    {
        return BuildingSetting::where('building_id', $building_id)->first();
    }

    /**
     * @inheritDoc
     * @see BuildingStatusRepositoryInterface::createDefault()
     */
    public function createDefault(int $building_id): BuildingSetting
    {
        return BuildingSetting::create([
            'building_id' => $building_id,
            // TODO
            // 'sales_suspension_title'   => preg_replace('/^[ \t]+|[ \t]+$/m', '', ''),
            // 'sales_suspension_message' => preg_replace('/^[ \t]+|[ \t]+$/m', '', ''),
            'sales_suspension_title'   => ' ',
            'sales_suspension_message' => ' ',
            'created_by' => Auth::guard('managers')->user()->id,
        ]);
    }

    /**
     * @inheritDoc
     * @see BuildingStatusRepositoryInterface::create()
     */
    public function create(array $param): BuildingSetting
    {
        return BuildingSetting::create($param);
    }

    /**
     * @inheritDoc
     * @see BuildingStatusRepositoryInterface::update()
     */
    public function update(BuildingSetting $building_setting, array $param): bool
    {
        return $building_setting->update($param);
    }

}
