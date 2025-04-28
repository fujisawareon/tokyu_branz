<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // キャッシュをクリアする
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        $this->call([
            MasterDataSeeder::class,
            BuildingSeeder::class,
            DisplayCustomerListColumnSeeder::class,
            ManagerSeeder::class,
            CustomerSeeder::class,
            AppLogSeeder::class,
        ]);
    }
}
