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
 * @property string $building_name
 * @property string $building_code
 * @property int $ip_restriction_flg
 * @property int $sales_status
 * @property int $unit_count
 *
 */
class BuildingSetting extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'building_setting';

    /**
     * 主キーを明示的に指定
     * @var string
     */
    protected $primaryKey = 'building_id';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'manager_id',
        'building_id',
        'sales_suspension_title',
        'sales_suspension_message',
        'building_site_url',
        'building_site_display_flg',
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
