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
        Schema::create('binder_building', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');

            $table->bigInteger('building_id')->default(0)->comment('物件ID');
            $table->bigInteger('binder_building_category_id')->default(0)->comment('資料集カテゴリID');
            $table->tinyInteger('binder_type')->default(0)->comment('資料タイプ-1:ファイル,2:URL');
            $table->string('file_path', 255)->nullable()->comment('ファイルパス');
            $table->string('url', 255)->nullable()->comment('URL');
            $table->string('thumbnail_file_path', 255)->nullable()->comment('ファイルパス');
            $table->string('binder_name', 100)->comment('登録名');
            $table->tinyInteger('sort')->default(0)->comment('並び順');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->nullable()->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            $table->index('building_id', 'idx_binder_building_building_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binder_building');
    }
};
