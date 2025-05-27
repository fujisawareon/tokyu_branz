<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Collection\Collection;

/**
 * @property int $id
 * @property int $role_type
 * @property Collection<int, Building> $buildings
 */
class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sei',
        'mei',
        'sei_kana',
        'mei_kana',
        'email',
        'password',
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
     * @param $building_id
     * @return HasOne
     */
    public function customerBuildingForBuilding($building_id)
    {
        return $this->hasOne(CustomerBuilding::class, 'customer_id')
            ->where('building_id', $building_id);
    }

    /**
     * @return BelongsToMany
     */
    public function buildings(): BelongsToMany
    {
        return $this->belongsToMany(
            Building::class,
            'customer_building',
            'customer_id',
            'building_id'
        )
            ->wherePivot('relation_status', CustomerBuilding::ENABLED)
            ->where(function ($query) {
                $query->where('buildings.sales_status', Building::SALES_STATUS_ON_SALE)
                    ->orWhere(function ($query) {
                        $query->where('buildings.sales_status', Building::SALES_STATUS_DELIVERY_SOLD_OUT)
                            ->where('customer_building.customer_status', CustomerBuilding::STATUS_CONTRACT);
                    });
            });
    }

}
