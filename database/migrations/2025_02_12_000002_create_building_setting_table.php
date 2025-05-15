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
        Schema::create('building_setting', function (Blueprint $table) {
            $table->bigIncrements('building_id')->comment('物件ID');
            $table->string('sales_suspension_title')->default('')->comment('販売停止タイトル');
            $table->string('sales_suspension_message')->default('')->comment('販売停止メッセージ');
            $table->string('location', 255)->nullable()->default(null)->comment('所在地');
            $table->string('nearest_station', 255)->nullable()->default(null)->comment('最寄り');
            $table->integer('max_building_price')->default(0)->comment('分譲価格最大値');
            $table->decimal('max_interest_rate', 6, 3)->default(0.000)->comment('金利最大値');
            $table->string('building_site_url', 255)->default('')->comment('物件サイトURL');
            $table->boolean('building_site_display_flg')->default(0)->comment('物件サイト表示フラグ');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            // インデックス
            $table->index(['building_id'], 'idx_building_setting_building_id');
        });



        Schema::create('building_setting_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('building_id')->comment('物件ID');

            $table->string('sales_suspension_title')->comment('販売停止タイトル');
            $table->string('sales_suspension_message')->comment('販売停止メッセージ');
            $table->string('location', 255)->nullable()->default(null)->comment('所在地');
            $table->string('nearest_station', 255)->nullable()->default(null)->comment('最寄り');
            $table->integer('max_building_price')->default(0)->comment('分譲価格最大値');
            $table->decimal('max_interest_rate', 6, 3)->default(0.000)->comment('金利最大値');
            $table->string('building_site_url', 255)->default('')->comment('物件サイトURL');
            $table->boolean('building_site_display_flg')->comment('物件サイト表示フラグ');

            $table->timestamp('original_created_at')->nullable()->comment('元の作成日時');
            $table->integer('created_by')->comment('作成者');
            $table->timestamp('original_updated_at')->nullable()->comment('元の更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->timestamp('history_created_at')->useCurrent()->comment('履歴作成日時');

            // インデックス
            $table->index(['building_id'], 'idx_building_setting_history_building_id');
        });

        DB::unprepared('
            CREATE TRIGGER trg_building_setting_after_update
            AFTER UPDATE ON building_setting
            FOR EACH ROW
            BEGIN
                INSERT INTO building_setting_history (
                    building_id,
                    sales_suspension_title,
                    sales_suspension_message,
                    location,
                    nearest_station,
                    max_building_price,
                    max_interest_rate,
                    building_site_url,
                    building_site_display_flg,
                    original_created_at,
                    created_by,
                    original_updated_at,
                    updated_by
                ) VALUES (
                    OLD.building_id,
                    OLD.sales_suspension_title,
                    OLD.sales_suspension_message,
                    OLD.location,
                    OLD.nearest_station,
                    OLD.max_building_price,
                    OLD.max_interest_rate,
                    OLD.building_site_url,
                    OLD.building_site_display_flg,
                    OLD.created_at,
                    OLD.created_by,
                    OLD.updated_at,
                    OLD.updated_by
                );
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_setting');
        Schema::dropIfExists('building_setting_history');
    }
};
