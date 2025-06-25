<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerBuilding;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        $bulk_insert_data = [];
        for ($customer_id = 1; $customer_id <= 1000; $customer_id++) {
            $factory = Customer::factory()->make()->toArray();

            $factory['email_verified_at'] = now()->format('Y-m-d H:i:s');
            $factory['password'] = static::$password ??= Hash::make('test');
            $bulk_insert_data[] = $factory;
        }

        // 一括挿入
        Customer::insert($bulk_insert_data);
    }
}
