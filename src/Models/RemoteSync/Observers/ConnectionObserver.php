<?php

namespace HibridVod\Database\Models\RemoteSync\Observers;

use Illuminate\Support\Str;
use HibridVod\Database\Models\RemoteSync\Connection;

/**
 * Class ConnectionObserver
 * @package HibridVod\Database\Models\RemoteSync\Observers
 */
class ConnectionObserver
{
    /**
     * @param \HibridVod\Database\Models\RemoteSync\Connection $connection
     */
    public function creating(Connection $connection): void
    {
        $connection->alias = $connection->tenant->alias . '_' . Str::slug($connection->name);
        $connection->is_locked = false;
    }
}
