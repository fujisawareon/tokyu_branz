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
        Schema::create('customer_pins', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->unsignedBigInteger('manager_id')->comment('業務ユーザーID');
            $table->unsignedBigInteger('building_id')->comment('物件ID');
            $table->unsignedBigInteger('customer_id')->comment('顧客ID');
            $table->softDeletes();

            // 複合インデックス
            $table->index(
                ['manager_id', 'building_id', 'customer_id', 'deleted_at'],
                'idx_mgr_building_customer_deleted'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_pins');
    }
};
