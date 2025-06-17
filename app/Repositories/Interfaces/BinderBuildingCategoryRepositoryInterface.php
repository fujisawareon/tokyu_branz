<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\BinderBuildingCategory;
use Illuminate\Database\Eloquent\Collection;

interface BinderBuildingCategoryRepositoryInterface
{
    /**
     * @return Collection<int, BinderBuildingCategory>
     */
    public function getBinderBuildingCategory(int $building_id): Collection;

    /**
     * @param int $building_id
     * @param int $category_id
     * @param string $category_name
     * @param int $sort
     * @param int $user_id
     */
    public function update(int $building_id, int $category_id, string $category_name, int $sort, int $user_id);

    /**
     * @param array $param
     * @return BinderBuildingCategory
     */
    public function create(array $param): BinderBuildingCategory;

}
