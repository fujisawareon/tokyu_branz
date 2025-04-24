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
 *
 * @property Building $building
 *
 */
class CustomerPin extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'customer_pins';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'manager_id',
        'building_id',
        'customer_id',
    ];

    public $timestamps = false; // ← created_at / updated_at は使わない

    /**
     * ブラックリスト
     * ※指定カラムのみ、create, fill, update不可
     * @var array
     */
    protected $guarded = [];

}
