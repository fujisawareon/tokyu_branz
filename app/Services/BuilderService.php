<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BinderBuilding;
use App\Models\BinderBuildingCategory;
use App\Repositories\Interfaces\BinderBuildingCategoryRepositoryInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class BuilderService
{
    private BinderBuildingCategoryRepositoryInterface $binder_building_category_repository;
    private BinderRepositoryInterface $binder_repository;

    public function __construct()
    {
        $this->binder_building_category_repository = app(BinderBuildingCategoryRepositoryInterface::class);
        $this->binder_repository = app(BinderRepositoryInterface::class);
    }

    /**
     * @return Collection<int, BinderBuildingCategory>
     */
    public function getBinderBuildingCategory(int $building_id): Collection
    {
        return $this->binder_building_category_repository->getBinderBuildingCategory($building_id);
    }

    /**
     * @param int $building_id
     * @param array $request
     * @return void
     */
    public function categoryUpdate(int $building_id, array $request): void
    {
        $sort = 1;
        $user_id = Auth::guard('managers')->user()->id;

        // 更新処理
        if (isset($request['id'])) {
            foreach ($request['id'] as $category_id) {
                if (isset($request['category_name'][$category_id])) {
                    // 更新処理
                    $this->binder_building_category_repository->update($building_id, (int)$category_id, $request['category_name'][$category_id], $sort, $user_id);

                    unset($request['category_name'][$category_id]);
                    $sort++;
                }
            }
        }

        // 新規登録
        foreach ($request['category_name'] as $category_name) {
            $this->binder_building_category_repository->create([
                'building_id' => $building_id,
                'category_name' => $category_name,
                'sort' => $sort,
                'created_by' => $user_id,
            ]);
            $sort++;
        }
    }

    /**
     * @param int $building_id
     * @param array $param
     * @param string|null $file_path
     * @return BinderBuilding
     */
    public function addBinder(int $building_id, array $param, ?string $file_path): BinderBuilding
    {
        return $this->binder_repository->create([
            'building_id' => $building_id,
            'binder_building_category_id' => $param['category_id'],
            'file_type' => $param['file_type'],
            'url' => $param['url'],
            'binder_name' => $param['binder_name'],
            'file_path' => $file_path,
        ]);
    }
}
