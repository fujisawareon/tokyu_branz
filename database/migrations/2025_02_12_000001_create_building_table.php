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
        Schema::create('buildings', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('物件ID');
            $table->string('building_name', 255)->comment('物件名');
            $table->string('building_8_digit_code', 10)->comment('物件8桁コード');
            $table->string('building_4_digit_code', 5)->comment('物件4桁コード');
            $table->tinyInteger('contents_design_flg')->default(0)->comment('限定コンテンツデザイン');
            $table->tinyInteger('sales_status')->default(0)->comment('販売フラグ');
            $table->string('top_image')->nullable()->comment('TOP画像');
            $table->string('thumbnail_image')->comment('サムネイル画像');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            // インデックス
            $table->index(['building_8_digit_code'], 'idx_buildings_building_8_digit_code');
            $table->index(['building_4_digit_code'], 'idx_buildings_building_4_digit_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
