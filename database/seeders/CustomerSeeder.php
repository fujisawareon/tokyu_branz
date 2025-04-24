<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class
CustomerSeeder extends Seeder
{
    protected static $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->create([
            'sei' => '姓',
            'mei' => '名',
            'sei_kana' => 'セイ',
            'mei_kana' => 'メイ',
            'email' => 'test@test.jp',
            'password' => static::$password ??= Hash::make('test'),
        ]);
        Customer::factory(3000)->create();
    }
}
