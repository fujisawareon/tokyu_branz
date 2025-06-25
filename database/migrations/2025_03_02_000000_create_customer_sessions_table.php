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
        Schema::create('customer_sessions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('customer_id')->comment('顧客ID');
            $table->string('uid', 255)->nullable()->comment('識別ID');
            $table->timestamp('last_login_at')->nullable()->comment('最終ログイン日時');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->softDeletes();

            // インデックス
            $table->index(['customer_id'], 'idx_customer_uids_customer_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_sessions');
    }
};
