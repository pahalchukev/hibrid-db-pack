<?php

namespace HibridVod\Database\Models\Traits;

/**
 * Trait UsesSystemConnection
 * @package HibridVod\Database\Traits\Models
 */
trait UsesSystemConnection
{
    /**
     * @return string
     */
    public function getConnectionName(): string
    {
        return config('hibrid-vod.database.connection_name', config('database.default'));
    }
}
