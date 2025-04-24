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
 * @property int $schedule_key
 * @property int $sort
 * @property int $display_flg
 *
 */
class ShareContentStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'share_content_status';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'building_id',
        'status_id',
        'content_key',
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
