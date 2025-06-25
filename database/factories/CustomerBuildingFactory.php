<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 */
class CustomerBuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'relation_status' => rand(1, 5) === 1 ? 0 : 1,
            'customer_status' => rand(0, 5),
            'prefecture' => $this->faker->randomElement(['東京都', '大阪府', '愛知県']),
            'city' => $this->faker->randomElement(['渋谷区', '港区', '世田谷区']),
            'town' => $this->faker->randomElement(['麻布', '芝浦', '祖師谷大蔵']),
            'chome' => rand(1, 5) . '丁目',
            'banchi' => rand(1, 50) . '-' . rand(1, 20),
            'apartment_detail' => $this->faker->randomElement([
                'サンシャインハイツ 101号室',
                'グリーンコート 202号室',
                'スカイレジデンス 305号室',
                'メゾンフローラ 1-A',
            ]),
            'budget' => rand(1000, 5000),
            'desired_area' => rand(20, 100),
            'expected_residents' => rand(1, 5),
            'purchase_purpose' => fake()->word(),
            'base_score' => rand(0, 100),
            'behavior_score' => rand(0, 999),
            'score' => rand(156, 268),
            'person_in_charge' => rand(0, 5),
            'created_by' => null,
            'updated_by' => null,
        ];
    }

}
