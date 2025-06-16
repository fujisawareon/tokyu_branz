<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Consts\CacheConsts;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class MovieRepository implements MovieRepositoryInterface
{
    /**
     * @inheritDoc
     * @see MovieRepositoryInterface::addMovie()
     */
    public function addMovie(array $param): Movie
    {
        return Movie::create($param);
    }

}
