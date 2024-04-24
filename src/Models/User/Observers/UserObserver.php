<?php

namespace HibridVod\Database\Models\User\Observers;

use HibridVod\Database\Models\User\User;

/**
 * Class UserObserver
 * @package HibridVod\Database\Models\User\Observers
 */
class UserObserver
{
    /**
     * Listen to the User saving event.
     *
     * @param \HibridVod\Database\Models\User\User $user
     *
     * @return void
     */
    public function creating(User $user): void
    {
        if ($user->password !== null) {
            $user->password = bcrypt($user->password);
        }
    }
}
