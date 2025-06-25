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
 * @property string $building_name
 * @property int $sales_status
 *
 * @property BuildingSetting $buildingSetting
 * @property Collection<int, Manager> $personCharge
 * @property Collection<int, ActionBtnSetting> $actionBtnSetting
 * @property Collection<int, BinderBuildingCategory> $binderBuildingCategory
 *
 */
class Building extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const SALES_STATUS_BEFORE_SALE = 1; // 販売前
    public const SALES_STATUS_ON_SALE = 2; // 販売中
    public const SALES_STATUS_CONTRACT_SOLD_OUT = 3; // 契約完売
    public const SALES_STATUS_DELIVERY_SOLD_OUT = 4; // 引渡完売
    public const SALES_STATUS = [
        self::SALES_STATUS_BEFORE_SALE => '準備中',
        self::SALES_STATUS_ON_SALE => '販売中',
        self::SALES_STATUS_CONTRACT_SOLD_OUT => '契約完売',
        self::SALES_STATUS_DELIVERY_SOLD_OUT => '引渡完売',
    ];

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'buildings';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'building_name',
        'building_8_digit_code',
        'building_4_digit_code',
        'sales_status',
        'site_url_flg',
        'site_url',
        'top_image',
        'thumbnail_image',
        'contents_url_flg',
        'created_by',
    ];

    /**
     * ブラックリスト
     * ※指定カラムのみ、create, fill, update不可
     * @var array
     */
    protected $guarded = [];

    /**
     * 物件設定情報とのリレーション
     * @return HasOne
     */
    public function buildingSetting(): HasOne
    {
        return $this->HasOne(BuildingSetting::class);
    }

    /**
     * 担当者とのリレーション
     * @return BelongsToMany<int, Manager>
     */
    public function personCharge(): BelongsToMany
    {
        return $this->BelongsToMany(Manager::class,'building_invitation');
    }

    /**
     * アクションボタン設定とのリレーション
     * @return HasMany<int, ActionBtnSetting>
     */
    public function actionBtnSetting(): HasMany
    {
        return $this->hasMany(ActionBtnSetting::class)->orderBy('sort');
    }

    /**
     * @return HasMany
     */
    public function binderBuildingCategory(): HasMany
    {
        return $this->hasMany(BinderBuildingCategory::class)->orderBy('sort');
    }

}
