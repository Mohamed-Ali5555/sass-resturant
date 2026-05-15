<?php

namespace App\Models;

use App\Enums\RoleName;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    use HasRoles {
        hasPermissionTo as protected spatieHasPermissionTo;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_disabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_disabled' => 'boolean',
        ];
    }

    public function ownedRestaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class, 'vendor_owner_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function restaurantsAsStaff(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_user')
            ->withPivot(['branch_id', 'staff_role', 'is_active'])
            ->withTimestamps();
    }

    public function activeRestaurantsAsStaff(): BelongsToMany
    {
        return $this->restaurantsAsStaff()->wherePivot('is_active', true);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleName::SuperAdmin->value);
    }

    /**
     * Super Admin bypass for Spatie permission checks (Gate::before does not apply to HasRoles::can).
     */
    public function hasPermissionTo($permission, $guardName = null): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->spatieHasPermissionTo($permission, $guardName);
    }

    public function canAccessRestaurant(Restaurant $restaurant): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->ownedRestaurants()->whereKey($restaurant->getKey())->exists()) {
            return true;
        }

        return $this->activeRestaurantsAsStaff()
            ->whereKey($restaurant->getKey())
            ->exists();
    }

    public function hasAnyRoleName(RoleName ...$roles): bool
    {
        return $this->hasAnyRole(array_map(fn (RoleName $r) => $r->value, $roles));
    }

    /**
     * @return list<string>
     */
    public function roleNamesForApi(): array
    {
        return $this->getRoleNames()->values()->all();
    }

    /**
     * @return list<string>
     */
    public function permissionNamesForApi(): array
    {
        return $this->getAllPermissions()->pluck('name')->values()->all();
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(
            Location::class,
            'restaurant_user',
            'user_id',
            'branch_id'
        );
    }
}
