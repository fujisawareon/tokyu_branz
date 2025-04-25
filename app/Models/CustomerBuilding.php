<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property HasOne $personCharge
 */
class CustomerBuilding extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const DISABLED = 0; // 無効
    public const ENABLED = 1; // 有効
    public const RELATION_STATUS_LIST = [
        self::DISABLED => '無効',
        self::ENABLED => '有効',
    ];

    public const STATUS_ENTRY = 1; // エントリー
    public const ONLINE_SEMINAR_MOVIE = 2; // オンラインセミナー動画
    public const STATUS_DISCUSSION_DISCONTINUED = 99; // 検討中止
    public const STATUS_LIST = [ // TODO
        self::STATUS_ENTRY => 'エントリー',
        self::ONLINE_SEMINAR_MOVIE => 'オンラインセミナー動画',
        3 => 'オンライン商談予約',
        4 => 'オンライン商談',
        5 => 'フリー見学予約',
        6 => 'フリー見学',
        7 => '初来場予約',
        8 => '初来場',
        9 => '要望',
        10 => '登録',
        11 => '申込',
        12 => '契約',
        13 => 'お引渡',
        14 => 'インナー',
        self::STATUS_DISCUSSION_DISCONTINUED => '検討中止',
    ];

    /**
     * モデルと関連しているテーブル
     * @var string
     */
    protected $table = 'customer_building';

    /**
     * 一括代入可能なカラム
     * @var string[]
     */
    protected $fillable = [
        'customer_id',
        'building_id',
        'relation_status',
    ];

    /**
     * ブラックリスト
     * ※指定カラムのみ、create, fill, update不可
     * @var array
     */
    protected $guarded = [];

    /**
     */
    public function personCharge(): HasOne
    {
        return $this->HasOne(Manager::class, 'id', 'person_in_charge');
    }
}
