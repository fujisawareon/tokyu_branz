<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $building_id
 * @property string $schedule_key
 * @property int $sort
 * @property int $display_flg
 *
 */
class SalesSchedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'sales_schedule';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'building_id',
        'schedule_key',
        'sort',
        'display_flg',
        'created_by',
        'updated_by',
    ];

    /**
     * ブラックリスト
     * ※指定カラムのみ、create, fill, update不可
     * @var array
     */
    protected $guarded = [];

}
