<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // パーティション付きテーブルの作成
        DB::statement('CREATE TABLE app_log (
            id BIGINT AUTO_INCREMENT NOT NULL,
            building_id INT UNSIGNED DEFAULT 0 COMMENT "物件ID",
            customer_id INT UNSIGNED DEFAULT 0 COMMENT "顧客ID",
            page_key VARCHAR(100) NOT NULL COMMENT "限定コンテンツキー",
            floor_plan_id INT NULL COMMENT "間取プランID",
            binder_building_id INT NULL COMMENT "物件資料ID",
            stay_time TIME NULL COMMENT "滞在時間",
            uid VARCHAR(255) COMMENT "識別ID",
            ip_address VARCHAR(255) COMMENT "IPアドレス",
            browser VARCHAR(255) COMMENT "ブラウザ",
            http_referer VARCHAR(500) NULL COMMENT "アクセス元",
            created_at_partition DATE COMMENT "作成日時_パーティション用",
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT "作成日時",
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時",
            deleted_at TIMESTAMP NULL COMMENT "削除日時",
            PRIMARY KEY (id, created_at_partition)
        ) PARTITION BY RANGE COLUMNS (created_at_partition) (
            PARTITION p2026 VALUES LESS THAN ("2027-01-01"),
            PARTITION p2027 VALUES LESS THAN ("2028-01-01"),
            PARTITION p2028 VALUES LESS THAN ("2029-01-01"),
            PARTITION p2029 VALUES LESS THAN ("2030-01-01"),
            PARTITION pmax VALUES LESS THAN MAXVALUE
        );');

        // インデックス
        DB::statement('CREATE INDEX idx_app_log_building_id ON app_log (building_id);');
        DB::statement('CREATE INDEX idx_app_log_customer_id ON app_log (customer_id);');
        DB::statement('CREATE INDEX idx_app_log_page_key ON app_log (page_key);');
        DB::statement('CREATE INDEX idx_app_log_floor_plan_id ON app_log (floor_plan_id);');
        DB::statement('CREATE INDEX idx_app_log_binder_building_id ON app_log (binder_building_id);');
        DB::statement('CREATE INDEX idx_app_log_created_at ON app_log (created_at);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_log');
    }
};
