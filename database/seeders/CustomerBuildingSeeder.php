<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CustomerBuilding;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerBuildingSeeder extends Seeder
{
    protected static $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 1人目の顧客を1つ目の物件に紐づける
        CustomerBuilding::factory()->create([
            'customer_id' => 1,
            'building_id' => 1,
        ]);

        // 2人目〜100人目のデータをまとめて登録
        $bulk_insert_data = [];
        for ($customer_id = 2; $customer_id <= 100; $customer_id++) {
            $factory = CustomerBuilding::factory()->make([
                'customer_id' => $customer_id,
                'building_id' => rand(1, 5),
            ]);

            $record = $factory->toArray();
            $bulk_insert_data[] = $record;
        }

        // 一括挿入
        DB::table('customer_building')->insert($bulk_insert_data);
    }
}
