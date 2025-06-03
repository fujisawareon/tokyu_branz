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
        Schema::create('image_gallery', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('building_id')->default(0)->comment('物件ID');
            $table->string('title', 100)->comment('画像タイトル');
            $table->string('image_file_name', 100)->comment('画像ファイルパス');
            $table->tinyInteger('sort')->default(0)->comment('並び順');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->nullable()->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            $table->index('building_id', 'idx_image_gallery_building_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_gallery');
    }
};
