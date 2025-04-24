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
        Schema::create('building_invitation', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->unsignedBigInteger('manager_id')->default(0)->comment('業務ユーザーID');
            $table->unsignedBigInteger('building_id')->default(0)->comment('物件ID');
            $table->tinyInteger('status')->default(0)->comment('状態');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            // インデックス
            $table->index(['manager_id'], 'idx_building_invitation_manager_id');
            $table->index(['building_id'], 'idx_building_invitation_building_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_invitation');
    }
};
