<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\BinderBuildingCategoryRepositoryInterface;
use App\Models\BinderBuildingCategory;
use App\Traits\FormTrait;
use Illuminate\Database\Eloquent\Collection;

class BinderBuildingCategoryRepository implements BinderBuildingCategoryRepositoryInterface
{
    use FormTrait;

    /**
     * @inheritDoc
     * @see BinderBuildingCategoryRepositoryInterface::getBinderBuildingCategory()
     */
    public function getBinderBuildingCategory(int $building_id): Collection
    {
        return BinderBuildingCategory::where('building_id', $building_id)
            ->orderBy('sort')
            ->get();
    }

    /**
     * @inheritDoc
     * @see BinderBuildingCategoryRepositoryInterface::update()
     */
    public function update(int $building_id, int $category_id, string $category_name, int $sort, int $user_id)
    {
        return BinderBuildingCategory::find($category_id)
            ->update([
                'category_name' => $category_name,
                'sort' => $sort,
                'updated_by' => $user_id,
            ]);
    }

    /**
     * @inheritDoc
     * @see BinderBuildingCategoryRepositoryInterface::create()
     */
    public function create(array $param): BinderBuildingCategory
    {
        return BinderBuildingCategory::create($param);
    }

}
