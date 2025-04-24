<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AppLog;
use Illuminate\Database\Seeder;

class AppLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1万件を10回作成する
        for ($i = 0; $i <= 10; $i++) {
            $app_log = AppLog::factory()->count(10000)->make()->toArray();
            AppLog::insert($app_log);
        }
    }
}
