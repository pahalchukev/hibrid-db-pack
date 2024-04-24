<?php

namespace HibridVod\Database\Models\User;

use Spatie\Permission\Guard;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Contracts\Role as RoleContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\User\Observers\RoleObserver;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Role
 * @package App\Models\Role
 */
class Role extends \Spatie\Permission\Models\Role implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use SoftDeletes;
    use Uuidable;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'guard_name',
        'is_reserved',
        'tenant_id',
        'services'
    ];

    /**
     * @var array<string>
     */
    protected $hidden = [
        'guard_name',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_reserved' => 'bool',
        'services' => 'json'
    ];

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        static::observe(RoleObserver::class);
    }

    /**
     * Find a role by its name and guard name.
     *
     * @param string      $name
     * @param string|null $guardName
     *
     * @return \Spatie\Permission\Contracts\Role|\Spatie\Permission\Models\Role
     *
     * @throws \Spatie\Permission\Exceptions\RoleDoesNotExist
     */
    public static function findByName(string $name, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('name', $name)->where('guard_name', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::named($name);
        }

        return $role;
    }

    /**
     * @param \Spatie\Permission\Contracts\Permission|int|string $permission
     *
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        $permissionName = $permission;
        $permissionClass = $this->getPermissionClass();

        if (is_string($permission)) {
            $permission = $permissionClass->findByName($permission, $this->getDefaultGuardName());
        }

        if (is_int($permission)) {
            $permission = $permissionClass->findById($permission, $this->getDefaultGuardName());
        }

        return $permission->group === $permissionName || $this->permissions->contains('id', $permission->id);
    }

    /**
     * @param array<string, mixed> $attributes
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

        $exist = static::where('name', $attributes['name'])
            ->where('tenant_id', $attributes['tenant_id'])
            ->where('guard_name', $attributes['guard_name'])
            ->first();

        if ($exist) {
            throw RoleAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
