<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class
ManagerSeeder extends Seeder
{
    protected static $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manager::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.jp',
            'role_type' => 1,
            'password' => static::$password ??= Hash::make('test'),
        ]);
        Manager::factory(20)->create();
    }
}
