<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\LimitedContents;
use App\Repositories\Interfaces\LimitedContentRepositoryInterface;
use App\Models\Building;
use App\Traits\FormTrait;
use Illuminate\Database\Eloquent\Collection;

class LimitedContentRepository implements LimitedContentRepositoryInterface
{
    use FormTrait;

    /**
     * @inheritDoc
     * @see LimitedContentRepositoryInterface::getByBuildingId()
     */
    public function getByBuildingId(int $building_id): Collection
    {
        return LimitedContents::where('building_id', $building_id)
            ->orderBy('sort')
            ->get();
    }

    /**
     * @inheritDoc
     * @see LimitedContentRepositoryInterface::create()
     */
    public function create(array $record): LimitedContents
    {
        return LimitedContents::create($record);
    }

    /**
     * @inheritDoc
     * @see LimitedContentRepositoryInterface::overwrite()
     */
    public function overwrite(LimitedContents $limited_content, array $param): bool
    {
        return $limited_content->fill($param)->save();
    }

}
