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
        Schema::create('app_log', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('限定コンテンツログID');
            $table->unsignedInteger('building_id')->default(0)->comment('物件ID');
            $table->unsignedInteger('customer_id')->default(0)->comment('顧客ID');
            $table->tinyInteger('page_num')->default(0)->comment('閲覧ページNo.');

            $table->time('stay_time')->nullable()->default(null)->comment('滞在時間');

            $table->dateTime('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->softDeletes();

            // インデックス
            $table->index(['building_id'], 'idx_app_log_building_id');
            $table->index(['customer_id'], 'idx_app_log_customer_id');
            $table->index(['page_num'], 'idx_app_log_page_num');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_log');
    }
};
