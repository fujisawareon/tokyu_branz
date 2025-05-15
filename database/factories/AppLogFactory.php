<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manager>
 */
class AppLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created_at = Carbon::parse($this->faker->dateTimeBetween('-1 month', 'now'));
        return [
            'building_id' => fake()->numberBetween(1, 20), // 1〜50 のランダムな数字
            'customer_id' => fake()->numberBetween(1, 50), // 1〜3 のランダムな数字
            'uid' => fake()->regexify('[A-Za-z0-9]{10}'), // 10文字のランダムな文字列
            'stay_time' => fake()->numberBetween(1, 59), // 1〜59秒 のランダムな数字
            'created_at' => $created_at,
        ];
    }
}
