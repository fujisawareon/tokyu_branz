<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manager>
 */
class BuildingFactory extends Factory
{
    private static int $sequence = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        self::$sequence++;

        return [
            'building_name' => '物件_' . self::$sequence,
            'building_8_digit_code' => 'XXXXXX' . self::$sequence,
            'building_4_digit_code' => 'XX' . self::$sequence,
            'sales_status' => fake()->numberBetween(1, 2), // 1〜2 のランダムな数字
            'created_by' => 1,
            'top_image' => '',
            'thumbnail_image' => '',
        ];
    }
}
