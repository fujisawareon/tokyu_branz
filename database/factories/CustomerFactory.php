<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Building;
use App\Models\CustomerBuilding;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manager>
 */
class CustomerFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'web_customer_id' => rand(100000, 999999),
            'sei' => fake()->lastName(),
            'mei' => fake()->firstName(),
            'sei_kana' => fake()->lastKanaName(),
            'mei_kana' => fake()->firstKanaName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'last_login_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Customer $customer) {
            // ランダムな Building を1〜6件紐付ける
            $buildings = Building::inRandomOrder()->where('id', '<=', 10)->limit(rand(1, 6))->get();

            $records = [];
            foreach ($buildings as $building) {
                $records[] = [
                    'customer_id' => $customer->id,
                    'building_id' => $building->id,
                    'relation_status' => rand(1, 5) === 1 ? 0 : 1,
                    'customer_status' => rand(0, 5),
                    'prefecture' => $this->faker->randomElement(['東京都', '大阪府', '愛知県']),
                    'city' => $this->faker->randomElement(['渋谷区', '港区府', '世田谷区']),
                    'town' => $this->faker->randomElement(['麻布', '芝浦', '祖師谷大蔵']),
                    'chome' => $this->faker->numberBetween(1, 5) . '丁目',
                    'banchi' => $this->faker->numberBetween(1, 50) . '-' . $this->faker->numberBetween(1, 20),
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
            CustomerBuilding::insert($records);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
