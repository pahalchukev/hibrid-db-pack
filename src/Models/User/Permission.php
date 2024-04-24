<?php

namespace HibridVod\Database\Models\User;

use Spatie\Permission\Guard;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use Spatie\Permission\Contracts\Permission as PermissionContract;

/**
 * Class Permission
 * @package HibridVod\Database\Models\User
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    use UsesSystemConnection;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'permissions';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'group',
        'guard_name',
        'service'
    ];

    /**
     * @param string $name
     * @param null   $guardName
     *
     * @return \Spatie\Permission\Contracts\Permission
     */
    public static function findByName(string $name, $guardName = null): PermissionContract
    {
        $condition = ['group' => $name];

        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        [$group, $permission] = array_pad(explode('.', $name), 2, null);

        if ($group && $permission) {
            $condition = array_merge($condition, [
                'name'  => $permission,
                'group' => $group,
            ]);
        }
        $permission = static::getPermissions($condition)->first();

        if (! $permission) {
            throw PermissionDoesNotExist::create($name, $guardName);
        }

        return $permission;
    }

    /**
     * @param array<string, mixed> $attributes
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Spatie\Permission\Models\Permission
     */
    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

        $permission = static::getPermissions(['name' => $attributes['name'], 'group' => $attributes['group']])->first();

        if ($permission) {
            throw PermissionAlreadyExists::create(
                $attributes['group'] . '.' . $attributes['name'],
                $attributes['guard_name']
            );
        }

        return static::query()->create($attributes);
    }
}
