<?php

namespace HibridVod\Database\Models\User\Observers;

use Illuminate\Support\Str;
use HibridVod\Database\Models\User\Role;

/**
 * Class RoleObserver
 * @package HibridVod\Database\Models\User\Observers
 */
class RoleObserver
{
    /**
     * @param \HibridVod\Database\Models\User\Role $role
     */
    public function saving(Role $role): void
    {
        if ($role->isDirty('name')) {
            $role->setAttribute('alias', Str::slug($role->name));
        }
    }
}
