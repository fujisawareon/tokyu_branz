<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\BuildingInvitation;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manager>
 */
class ManagerFactory extends Factory
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'role_type' => 3,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * @return ManagerFactory|Factory
     */
    public function configure()
    {
        return $this->afterCreating(function (Manager $manager) {
            // ランダムな Building を1〜6件紐付ける
            $buildings = Building::inRandomOrder()->where('id', '<=', 5)->limit(rand(1, 5))->get();

            $records = [];
            foreach ($buildings as $building) {
                $records[] = [
                    'manager_id' => $manager->id,
                    'building_id' => $building->id,
                    'created_by' => 1,
                    'updated_by' => null,
                ];
            }
            BuildingInvitation::insert($records);
        });
    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
