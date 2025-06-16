<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\MovieCategory;
use Illuminate\Database\Eloquent\Collection;

interface MovieCategoryRepositoryInterface
{
    /**
     * @param int $building_id
     * @param int $movie_type
     * @return Collection<int, MovieCategory>
     */
    public function getMovieList(int $building_id, int $movie_type): Collection;
}
