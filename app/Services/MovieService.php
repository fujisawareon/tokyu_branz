<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Movie;
use App\Models\ShareContentStatus;
use App\Repositories\Interfaces\MovieCategoryRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MovieService
{
    /** @var MovieRepositoryInterface $movie_repository */
    private MovieRepositoryInterface $movie_repository;

    /** @var MovieCategoryRepositoryInterface $movie_category_repository */
    private MovieCategoryRepositoryInterface $movie_category_repository;

    /**
     */
    public function __construct()
    {
        $this->movie_category_repository = app( MovieCategoryRepositoryInterface::class);
        $this->movie_repository = app( MovieRepositoryInterface::class);
    }

    /**
     * @param int $building_id
     * @param int $status_id
     * @return Collection<int, ShareContentStatus>
     */
    public function getMovieList(int $building_id, int $movie_type): Collection
    {
        return $this->movie_category_repository->getMovieList($building_id, $movie_type);
    }

    /**
     * @param array $param
     * @return Movie
     */
    public function addMovie(array $param): Movie
    {
        return $this->movie_repository->addMovie($param);
    }
}
