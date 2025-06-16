<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface MovieRepositoryInterface
{
    /**
     * @param array $param
     * @return Movie
     */
    public function addMovie(array $param): Movie;
}
