<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $building_id
 * @property string $title
 * @property string $image_file_name
 * @property int $sort
 * @property $updated_by
 * @property $deleted_at
 *
 */
class ImageGallery extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'image_gallery';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'building_id',
        'title',
        'image_file_name',
    ];

    /**
     * ブラックリスト
     * ※指定カラムのみ、create, fill, update不可
     * @var array
     */
    protected $guarded = [];
}
