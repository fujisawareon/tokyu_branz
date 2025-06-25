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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('顧客ID');
            $table->string('web_customer_id')->nullable()->comment('WEB顧客ID');
            $table->string('sei')->comment('姓');
            $table->string('mei')->comment('名');
            $table->string('sei_kana')->comment('姓（カナ）');
            $table->string('mei_kana')->comment('名（カナ）');
            $table->string('tel')->nullable()->comment('電話番号');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(0)->comment('状態');
            $table->rememberToken();
            $table->tinyInteger('first_registration_flag')->default(0)->comment('初回登録済フラグ');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->nullable()->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            // インデックス
            $table->index(['web_customer_id'], 'idx_customers_web_customer_id');
            $table->index(['email'], 'idx_customers_email');
        });

        Schema::create('customer_building', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->unsignedBigInteger('customer_id')->comment('顧客ID');
            $table->unsignedBigInteger('building_id')->comment('物件ID');
            $table->unsignedBigInteger('person_in_charge')->nullable()->comment('担当');

            $table->tinyInteger('domestic_flag')->default(0)->comment('国内フラグ');
            $table->string('zip_code_3', 3)->nullable()->comment('郵便番号3桁');
            $table->string('zip_code_4', 4)->nullable()->comment('郵便番号4桁');
            $table->string('prefecture', 50)->nullable()->comment('都道府県');
            $table->string('city', 50)->nullable()->comment('市区町村');
            $table->string('town', 50)->nullable()->comment('町名');
            $table->string('chome', 50)->nullable()->comment('丁名');
            $table->string('banchi', 50)->nullable()->comment('番地');
            $table->string('apartment_detail', 50)->nullable()->comment('建物名・号室');
            $table->string('country', 50)->nullable()->comment('国名');
            $table->string('address_extra', 50)->nullable()->comment('その他住所');

            $table->integer('desired_area')->nullable()->comment('希望面積');
            $table->integer('budget')->default(0)->comment('予算');
            $table->integer('expected_residents')->nullable()->comment('住居予定人数');
            $table->string('purchase_purpose', 255)->nullable()->comment('購入目的');
            $table->tinyInteger('customer_status')->default(0)->comment('ステータス');
            $table->integer('base_score')->default(0)->comment('基本スコア');
            $table->integer('behavior_score')->default(0)->comment('行動スコア');
            $table->string('score')->nullable()->comment('総合スコア');
            $table->tinyInteger('relation_status')->default(0)->comment('状態');
            $table->timestamp('entry_at')->nullable()->comment('エントリー日時');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->integer('created_by')->nullable()->comment('作成者');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->softDeletes();

            // インデックス
            $table->index(['building_id'], 'idx_customer_building_building_id');
            $table->index(['customer_id'], 'idx_customer_building_customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('customer_building');
    }
};
