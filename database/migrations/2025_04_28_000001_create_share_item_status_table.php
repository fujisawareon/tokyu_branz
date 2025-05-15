<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('share_item_status', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->unsignedBigInteger('building_id')->comment('物件ID');
            $table->unsignedBigInteger('status_id')->comment('ステータスID');
            $table->tinyInteger('data_type')->comment('データタイプ');
            $table->tinyInteger('external_id')->comment('結合する外部テーブルのID');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->nullable()->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            $table->index(['building_id'], 'idx_share_item_status_building_id');
            $table->index(['status_id'], 'idx_share_item_status_status_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_item_status');
    }
};
