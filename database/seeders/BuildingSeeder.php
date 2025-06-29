<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Building;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $building = [
            [
                'building_name' => '新宿',
                'building_8_digit_code' => 'XXXXXXXX',
                'building_4_digit_code' => 'XXXX',
                'created_by' => 1,
                'sales_status' => 2,
                'top_image' => 'top_image_1750756711_スクリーンショット 2024-12-10 101421.png',
                'thumbnail_image' => 'thumbnail_image_1750756711_195101_p1.jpg',
            ], [
                'building_name' => '渋谷',
                'building_8_digit_code' => 'XXXXXXXX',
                'building_4_digit_code' => 'XXXX',
                'created_by' => 1,
                'sales_status' => 1,
                'top_image' => '',
                'thumbnail_image' => '',
            ]
        ];
        Building::insert($building);
        Building::factory(30)->create();
    }
}
