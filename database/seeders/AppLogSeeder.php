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

            // // IDを明示的に設定
            // foreach ($app_log as $index => $log) {
            //     $log['id'] = ($i * 10000) + ($index + 1); // 一意のIDを設定
            //     $app_log[$index] = $log;
            // }

            // 500件ずつに分割して挿入
            $chunks = array_chunk($app_log, 500);
            foreach ($chunks as $chunk) {
                AppLog::insert($chunk);
            }
        }
    }
}
