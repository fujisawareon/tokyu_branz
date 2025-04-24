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
 * @property Building $building
 *
 */
class BuildingInvitation extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const ROLE_TYPE_NON = 0; // 未設定
    public const ROLE_TYPE_EMPLOYEES = 1; // 社員
    public const ROLE_TYPE_COOPERATIVE_SALES = 2; // 協販　
    public const ROLE_TYPE_LIST = [
        self::ROLE_TYPE_NON => '未設定',
        self::ROLE_TYPE_EMPLOYEES => '社員',
        self::ROLE_TYPE_COOPERATIVE_SALES => '協販',
    ];
    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'building_invitation';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'manager_id',
        'building_id',
        'created_by',
    ];

    /**
     * ブラックリスト
     * ※指定カラムのみ、create, fill, update不可
     * @var array
     */
    protected $guarded = [];

    /**
     */
    public function building(): BelongsTo
    {
        return $this->BelongsTo(Building::class);
    }

}
