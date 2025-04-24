<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Manager;
use App\Models\Building;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $repo_list = require __DIR__ . '/repo_list.php';
        foreach ($repo_list as $repo) {
            $this->app->bind($repo['interface'], $repo['class']);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-building', function (Manager $manager_user, Building $building) {
            // TODO ログインユーザーが閲覧していい物件か確認する
            return false;
        });
    }
}
