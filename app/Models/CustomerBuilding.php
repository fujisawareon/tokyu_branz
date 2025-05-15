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
    public const STATUS_ONLINE_SEMINAR_MOVIE = 2; // オンラインセミナー動画
    public const STATUS_ONLINE_MEETING_RESERVATION = 3; // オンライン商談予約
    public const STATUS_ONLINE_MEETING = 4; //オンライン商談
    public const STATUS_FREE_TOUR_RESERVATION = 5; // フリー見学予約
    public const STATUS_FREE_TOUR = 6; //フリー見学
    public const STATUS_FIRST_VISIT_RESERVATION = 7; // 初来場予約
    public const STATUS_FIRST_VISIT = 8; // 初来場
    public const STATUS_INQUIRY = 9; // 要望
    public const STATUS_REGISTRATION = 10; // 登録
    public const STATUS_APPLICATION = 11; // 申込
    public const STATUS_CONTRACT = 12; // 契約
    public const STATUS_HANDOVER = 13; // お引渡
    public const STATUS_INNER = 14; // インナー
    public const STATUS_DISCUSSION_DISCONTINUED = 99; // 検討中止
    public const STATUS_LIST = [
        self::STATUS_ENTRY => 'エントリー',
        self::STATUS_ONLINE_SEMINAR_MOVIE => 'オンラインセミナー動画',
        self::STATUS_ONLINE_MEETING_RESERVATION => 'オンライン商談予約',
        self::STATUS_ONLINE_MEETING => 'オンライン商談',
        self::STATUS_FREE_TOUR_RESERVATION => 'フリー見学予約',
        self::STATUS_FREE_TOUR => 'フリー見学',
        self::STATUS_FIRST_VISIT_RESERVATION => '初来場予約',
        self::STATUS_FIRST_VISIT => '初来場',
        self::STATUS_INQUIRY => '要望',
        self::STATUS_REGISTRATION => '登録',
        self::STATUS_APPLICATION => '申込',
        self::STATUS_CONTRACT => '契約',
        self::STATUS_HANDOVER => 'お引渡',
        self::STATUS_INNER => 'インナー',
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
