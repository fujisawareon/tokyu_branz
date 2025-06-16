<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\MovieCategoryRepositoryInterface;
use App\Models\MovieCategory;
use Illuminate\Database\Eloquent\Collection;

class MovieCategoryRepository implements MovieCategoryRepositoryInterface
{
    /**
     * @inheritDoc
     * @see MovieCategoryRepositoryInterface::getMovieList()
     */
    public function getMovieList(int $building_id, int $movie_type): Collection
    {
        return MovieCategory::where('building_id', $building_id)
            ->where('movie_type', $movie_type)
            ->with('movie')
            ->get();
    }

}
