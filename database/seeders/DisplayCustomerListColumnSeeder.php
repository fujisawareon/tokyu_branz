<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DisplayCustomerListColumn;
use Illuminate\Database\Seeder;

class DisplayCustomerListColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [];

        foreach (DisplayCustomerListColumn::ITEM_NAME_LIST as $item_name) {
            $records[] = [
                'building_id' => 1,
                'item_name' => $item_name,
                'created_by' => 1,
            ];
        }
        DisplayCustomerListColumn::insert($records);
    }
}
