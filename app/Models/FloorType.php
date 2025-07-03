<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $building_name
 * @property int $sales_status
 *
 * @property BuildingSetting $buildingSetting
 * @property-read Collection<int, Manager> $personCharge
 * @property-read Collection<int, ActionBtnSetting> $actionBtnSetting
 * @property-read Collection<int, BinderBuildingCategory> $binderBuildingCategory
 * @property-read Collection<int, SalesSchedule> $salesSchedule
 *
 */
class FloorType extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'floor_type';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'created_by',
    ];

    /**
     * ブラックリスト
     * ※指定カラムのみ、create, fill, update不可
     * @var array
     */
    protected $guarded = [];

}
