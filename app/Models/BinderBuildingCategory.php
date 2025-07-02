<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $building_id
 * @property string $category_name
 * @property int $sort
 * @property-read Collection<int, BinderBuilding> $binderBuilding
 */
class BinderBuildingCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'binder_building_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'building_id',
        'category_name',
        'sort',
        'created_by',
        'updated_by',
    ];

    /**
     * @return BelongsToMany
     */
    public function binderBuilding(): HasMany
    {
        return $this->hasMany(BinderBuilding::class)->orderBy('sort');
    }
}
