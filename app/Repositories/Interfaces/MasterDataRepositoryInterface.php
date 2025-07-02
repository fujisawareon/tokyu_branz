<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\MasterData;
use Illuminate\Database\Eloquent\Collection;

interface MasterDataRepositoryInterface
{

    /**
     * @param int $type
     * @return Collection<int, MasterData>
     */
    public function getMasterDataByDataType(int $type): Collection;

}
