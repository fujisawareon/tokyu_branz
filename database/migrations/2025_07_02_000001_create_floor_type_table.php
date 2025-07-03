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
        Schema::create('floor_type', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('building_id')->comment('物件ID');
            $table->string('type_name', 100)->comment('間取タイプ名');
            $table->tinyInteger('sort')->default(0)->comment('並び順');
            $table->boolean('display_flg')->default(0)->comment('表示フラグ');
            $table->decimal('area_m2', 10, 2)->default(0)->comment('専有面積の㎡');
            $table->decimal('area_tsubo', 10, 2)->default(0)->comment('専有面積の坪');
            $table->tinyInteger('direction')->default(0)->comment('方位');
            $table->json('additional_data')->comment('専有面積以外の名前、㎡、坪');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            // インデックス
            $table->index(['building_id'], 'idx_plan_building_id');
        });

        Schema::create('floor_type_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('floor_type_id')->comment('floor_typeのID');
            $table->bigInteger('building_id')->comment('物件ID');
            $table->string('type_name', 100)->comment('間取タイプ名');
            $table->tinyInteger('sort')->default(0)->comment('並び順');
            $table->boolean('display_flg')->default(0)->comment('表示フラグ');
            $table->decimal('area_m2', 10, 2)->default(0)->comment('専有面積の㎡');
            $table->decimal('area_tsubo', 10, 2)->default(0)->comment('専有面積の坪');
            $table->tinyInteger('direction')->default(0)->comment('方位');
            $table->json('additional_data')->comment('専有面積以外の名前、㎡、坪');

            $table->timestamp('created_at')->comment('作成日時');
            $table->integer('created_by')->comment('作成者');
            $table->timestamp('updated_at')->nullable()->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');

            // インデックス
            $table->index(['building_id'], 'idx_floor_type_history_building_id');
        });

        DB::unprepared('
            CREATE TRIGGER trg_floor_type_after_update
            AFTER UPDATE ON floor_type
            FOR EACH ROW
            BEGIN
                INSERT INTO floor_type_history (
                    floor_type_id,
                    building_id,
                    type_name,
                    sort,
                    display_flg,
                    area_m2,
                    area_tsubo,
                    direction,
                    additional_data,
                    created_at,
                    created_by,
                    updated_at,
                    updated_by
                ) VALUES (
                    OLD.id,
                    OLD.building_id,
                    OLD.type_name,
                    OLD.sort,
                    OLD.display_flg,
                    OLD.area_m2,
                    OLD.area_tsubo,
                    OLD.direction,
                    OLD.additional_data,
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
        Schema::dropIfExists('floor_type');
        Schema::dropIfExists('floor_type_history');
    }
};
