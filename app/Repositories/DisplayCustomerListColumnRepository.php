<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\DisplayCustomerListColumn;
use App\Repositories\Interfaces\DisplayCustomerListColumnRepositoryInterface;
use App\Traits\FormTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DisplayCustomerListColumnRepository implements DisplayCustomerListColumnRepositoryInterface
{
    use FormTrait;

    /**
     * @inheritDoc
     * @see DisplayCustomerListColumnRepositoryInterface::getByBuildingId()
     */
    public function getByBuildingId(int $building_id, bool $all): Collection
    {
        $query = DisplayCustomerListColumn::where('building_id', $building_id);

        if ($all) {
            return $query->get();
        }

        return $query->whereNotIn('item_type', [2])->get(); // TODO スコアを除く

    }

    /**
     * @inheritDoc
     * @see DisplayCustomerListColumnRepositoryInterface::insert()
     */
    public function insert(array $records)
    {
        return DisplayCustomerListColumn::insert($records);
    }

    /**
     * @inheritDoc
     * @see DisplayCustomerListColumnRepositoryInterface::delete()
     */
    public function delete(int $building_id, int $manager_id, bool $all = false)
    {
        $query = DisplayCustomerListColumn::where('building_id', $building_id);

        if (!$all) {
            // スコアを除く
            $query->whereNotIn('item_name', [
                DisplayCustomerListColumn::ITEM_NAME_BASE_SCORE,
                DisplayCustomerListColumn::ITEM_NAME_BEHAVIOR_SCORE,
                DisplayCustomerListColumn::ITEM_NAME_SCORE,
            ]);
        }

        return $query->update([
            'updated_by' => $manager_id,
            'deleted_at' => Carbon::now(),
        ]);
    }

}
