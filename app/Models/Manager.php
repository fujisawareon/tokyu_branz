<?php

namespace App\Models;

use App\Models\BuildingInvitation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property int $role_type
 * @property Collection<int, BuildingInvitation> $invitationBuilding
 */
class Manager extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\ManagerFactory> */
    use HasFactory, Notifiable;

    public const ROLE_TYPE_NON = 0; // 未設定
    public const ROLE_TYPE_SARA = 1; // システム管理者
    public const ROLE_TYPE_SERVICE = 2; // サービス管理者
    public const ROLE_TYPE_EMPLOYEE = 3; // 販売担当者(社員)
    public const ROLE_TYPE_COOPERATION = 4; // 販売担当者(協販)
    public const ROLE_TYPE_LIST = [
        self::ROLE_TYPE_NON => '未設定',
        self::ROLE_TYPE_SARA => 'システム管理者',
        self::ROLE_TYPE_SERVICE => 'サービス管理者',
        self::ROLE_TYPE_EMPLOYEE => '販売担当者(社員)',
        self::ROLE_TYPE_COOPERATION => '販売担当者(協販)',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_type',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     */
    public function invitationBuilding(): HasMany
    {
        return $this->HasMany(BuildingInvitation::class);
    }


}
