<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MasterData;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $master_data_list = [
            MasterData::LIMITED_CONTENT => [ // 限定コンテンツ
                'schedule' => 'スケジュール',
                'online_seminar_movie' => 'オンラインセミナー動画',
                'introduction_video' => '紹介動画',
                'plan' => '間取り',
                'private_area_vr' => '専有部VR',
                'plan_view_simulation' => '平面眺望シミュレーション',
                'shadow_simulation' => '日影シミュレーション',
                'common_area_vr' => '外観、共用部VR',
                'image_gallery' => '画像ギャラリー',
                'furniture_layout_simulation' => '家具レイアウトシミュレーション',
                'area_map' => '周辺マップ',
                'local_photos' => '現地写真',
                'building_documents' => '物件資料集',
                'only_presentation_documents' => '担当者専用資料集',
                'loan_simulation' => 'ローンシミュレーション',
                'sales_price_list' => '販売価格表',
            ],
            MasterData::SALES_SCHEDULE => [ // 販売スケジュール
                'entry' =>'エントリー',
                'online_seminar' =>'オンラインセミナー',
                'online_meeting' =>'オンライン商談',
                'free_tour' =>'フリー見学',
                'visit' =>'ご来場',
                'request' =>'ご要望',
                'registration' =>'ご登録',
                'application' =>'お申込',
                'contract' =>'ご契約',
            ],
        ];

        $records = [];
        foreach ($master_data_list as $data_type => $data_list) {
            $sort = 1;
            foreach($data_list as $data_key => $data_name) {
                $records[] = [
                    'data_key' => $data_key,
                    'data_type' => $data_type,
                    'name' => $data_name,
                    'sort' =>$sort,
                ];
                $sort++;
            }
        }

        MasterData::insert($records);
    }
}
