<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 */
class DisplayCustomerListColumn extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const ITEM_NAME_ADDRESS = 'address'; // 住所
    public const ITEM_NAME_DESIRED_AREA = 'desired_area'; // 希望面積
    public const ITEM_NAME_BUDGET = 'budget'; // 予算
    public const ITEM_NAME_EXPECTED_RESIDENTS = 'expected_residents'; // 住居予定人数
    public const ITEM_NAME_PURCHASE_PURPOSE = 'purchase_purpose'; // 購入目的
    public const ITEM_NAME_CUSTOMER_STATUS = 'customer_status'; // ステータス
    public const ITEM_NAME_BASE_SCORE = 'base_score'; // 基本スコア
    public const ITEM_NAME_BEHAVIOR_SCORE = 'behavior_score'; // 行動スコア
    public const ITEM_NAME_SCORE = 'score'; // 総合スコア
    public const ITEM_NAME_RELATION_STATUS = 'relation_status'; // 状態
    public const ITEM_NAME_LAST_LOGIN_AT = 'last_login_at'; // 最終ログイン日時
    public const ITEM_NAME_LIST = [
        self::ITEM_NAME_ADDRESS,
        self::ITEM_NAME_DESIRED_AREA,
        self::ITEM_NAME_BUDGET,
        self::ITEM_NAME_EXPECTED_RESIDENTS,
        self::ITEM_NAME_PURCHASE_PURPOSE,
        self::ITEM_NAME_CUSTOMER_STATUS,
        self::ITEM_NAME_BASE_SCORE,
        self::ITEM_NAME_BEHAVIOR_SCORE,
        self::ITEM_NAME_SCORE,
        self::ITEM_NAME_RELATION_STATUS,
        self::ITEM_NAME_LAST_LOGIN_AT,
    ];

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'display_customer_list_column';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
    ];

    /**
     * ブラックリスト
     * ※指定カラムのみ、create, fill, update不可
     * @var array
     */
    protected $guarded = [];

}
